<?php


namespace src\Data\DTO;


class UserDTO
{
    private string $id;

    private string $username;

    private string $password;

    private string $firstName;

    private string $lastName;

    private ?string $bornOn = null;

    private ?string $profilePictureUrl = null;

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    /**
     * @return ?string
     */
    public function getBornOn(): ?string
    {
        return $this->bornOn;
    }

    /**
     * @param ?string $bornOn
     */
    public function setBornOn(?string $bornOn): void
    {
        $this->bornOn = $bornOn;
    }

    /**
     * @return ?string
     */
    public function getProfilePictureUrl(): ?string
    {
        return $this->profilePictureUrl;
    }

    /**
     * @param ?string $profilePictureUrl
     */
    public function setProfilePictureUrl(?string $profilePictureUrl): void
    {
        $this->profilePictureUrl = $profilePictureUrl;
    }
}