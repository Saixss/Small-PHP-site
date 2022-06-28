let sidebarLinks = document.getElementsByClassName("sidebar-links");

Array.from(sidebarLinks).forEach(function(element) {
    element.addEventListener("mouseover", function (event) {
        event.target.style.textDecoration = "underline";
    }, false);

    element.addEventListener("mouseout", function (event) {
        event.target.style.textDecoration = "none";
    }, false);
});

let pageNumbers = document.getElementsByClassName("page-number");

Array.from(pageNumbers).forEach(function (element) {
    element.addEventListener("mouseover", function (event) {
        event.target.style.backgroundColor = "#8892BF";
        event.target.style.fontSize = "1rem";
        event.target.style.lineHeight = "40px";
        event.target.style.top =
        event.target.style.height = "40px";
        event.target.style.width = "40px";

    }, false);

    element.addEventListener("mouseout", function ( event ) {

        setTimeout(function () {
            event.target.style.backgroundColor = "";
            event.target.style.fontSize = "";
            event.target.style.lineHeight = "";
            event.target.style.height = "";
            event.target.style.width = "";
        }, 200)
    }, false);
});

/*
 * Solves tabulation problem in textarea
 */

let textareas = document.getElementsByTagName("textarea");

Array.from(textareas).forEach(function (element) {
    element.addEventListener("keydown", e => {
            if (e.key === "Tab" && !e.shiftKey) {
                document.execCommand("insertText", false, "\t");
                e.preventDefault();
                return false;
            }
    })
});

/* Toggle between adding and removing the "responsive" class to topnav when the user clicks on the icon */
function myFunction() {
    let x = document.getElementsByClassName("tips")[0];

    if (x.className === "tips") {
        x.className += " responsive";
    } else {
        x.className = "tips";
    }
}

function hideForm() {
    let form = document.getElementsByClassName("form-style-9 answer")[0];

    if (form.className === "form-style-9 answer hidden") {
        form.className = "form-style-9 answer";
    } else {
        form.className = "form-style-9 answer hidden";
    }
}
