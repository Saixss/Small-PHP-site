<?php


namespace src\Service\User;


use src\Data\DTO\UserDTO;
use src\Data\Entity\User;
use src\Data\Exception\User\UserEditException;
use src\Data\Exception\User\UserLoginException;
use src\Data\Exception\User\UserRegisterException;
use src\Repository\User\UserRepositoryInterface;
use core\Encryption\EncryptionServiceInterface;

class UserService implements UserServiceInterface
{
    private UserRepositoryInterface $userRepository;

    private EncryptionServiceInterface $encryptionService;

    public function __construct(UserRepositoryInterface $userRepository, EncryptionServiceInterface $encryptionService)
    {
        $this->userRepository = $userRepository;
        $this->encryptionService = $encryptionService;
    }

    /**
     * @param User $user
     * @param string $confirmPassword
     * @throws UserRegisterException
     */
    public function register(User $user, string $confirmPassword): void
    {
        $baseUser = $this->userRepository->getUserByUsername($user->getUsername());

        $this->validateUserRegister($user, $baseUser, $confirmPassword);

        $passwordHash = $this->encryptionService->hash($user->getPassword());

        $user->setPassword($passwordHash);

        $this->userRepository->insert($user);
    }

    /**
     * @param string $username
     * @param string $password
     * @return UserDTO
     * @throws UserLoginException
     */
    public function login(string $username, string $password): UserDTO
    {
        $baseUser = $this->userRepository->getUserByUsername($username);

        if ($baseUser === null) {
            throw new UserLoginException("Invalid username or password");
        }

        $hash = $baseUser->getPassword();

        if ($this->encryptionService->verify($password, $hash) === false) {
            throw new UserLoginException("Invalid username or password");
        }

        return $baseUser;
    }

    /**
     * @param int $id
     * @param User $data
     * @return bool
     * @throws UserEditException
     */
    public function edit(int $id, User $data): bool
    {
        $currentUser = $this->userRepository->getUserById($id);
        $existentUser = $this->userRepository->getUserByUsername($data->getUsername());

        if ($existentUser && $currentUser->getUsername() !== $existentUser->getUsername()) {
            throw new UserEditException("Username taken");
        }

        if ($_FILES["img"]["tmp_name"] !== "") {
            $this->uploadImage($currentUser, $data);
        }

        return $this->userRepository->edit($id, $data);
    }

    public function getUserById(int $userId): UserDTO
    {
        return $this->userRepository->getUserById($userId);
    }

    /**
     * @param UserDTO $currentUser
     * @param User $data
     * @throws UserEditException
     */
    private function uploadImage(UserDTO $currentUser, User $data)
    {
        $allowedTypes = ["image/png", "image/jgp", "image/jpeg", "image/gif"];
        $fileType = $_FILES["img"]["type"];

        $check = getimagesize($_FILES["img"]["tmp_name"]);

        if ($check === false) {
            throw new UserEditException("File is not an image");
        }

        if (in_array($fileType, $allowedTypes) === false) {
            throw new UserEditException("Invalid image type");
        }

        if ($_FILES["img"]["size"] > 5000000) {
            throw new UserEditException("Image size is too large");
        }

        $targetDir = "public/images/user/";
        $nameAndExt = explode(".", $_FILES["img"]["name"]);
        $_FILES["img"]["name"] = "IMG_" . date("Y-m-d") . "_" . $nameAndExt[0] . "_" . hash("sha256", rand()) . "." . $nameAndExt[1];
        $fileName = basename($_FILES["img"]["name"]);
        $targetFile = $targetDir . $fileName;

        if(move_uploaded_file($_FILES["img"]["tmp_name"], $targetFile)) {
            $data->setProfilePictureUrl($fileName);

            if ($currentUser->getProfilePictureUrl() !== null) {
                $oldPicture = $targetDir . $currentUser->getProfilePictureUrl();
                unlink($oldPicture);
            }
        } else {
            throw new UserEditException("Something went wrong while uploading");
        }
    }

    /**
     * @param User|null $currentUser
     * @param UserDTO|null $baseUser
     * @param string|null $confirmPassword
     * @throws UserRegisterException
     */
    private function validateUserRegister(User $currentUser = null, UserDTO $baseUser = null, string $confirmPassword = null)
    {
        if ($baseUser !== null) {
            throw new UserRegisterException("Username already exits!");
        }

        if ($currentUser->getPassword() !== $confirmPassword) {
            throw new UserRegisterException("Password mismatch!");
        }

        if (strlen($currentUser->getUsername()) > 24) {
            throw new UserRegisterException("Username max length is 24 syllables");
        }

        if (strlen($currentUser->getUsername()) < 4) {
            throw new UserRegisterException("Username min length is 4 syllables");
        }

        if (strlen($currentUser->getFirstName()) > 24) {
            throw new UserRegisterException("First Name max length is 24 syllables");
        }

        if (strlen($currentUser->getFirstName()) < 1) {
            throw new UserRegisterException("First Name min length is 1 syllable");
        }

        if (strlen($currentUser->getLastName()) > 24) {
            throw new UserRegisterException("Last Name max length is 24 syllables");
        }

        if (strlen($currentUser->getLastName()) < 1) {
            throw new UserRegisterException("Last Name min length is 1 syllable");
        }
    }
}