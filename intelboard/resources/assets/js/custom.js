// language: javascript
(function () {
    "use strict";

    /* page loader */
    function hideLoader() {
        const loader = document.getElementById("loader");
        loader.classList.add("d-none");
    }

    window.addEventListener("load", hideLoader);
    /* page loader */

    /* tooltip */
    const tooltipTriggerList = document.querySelectorAll(
        '[data-bs-toggle="tooltip"]'
    );
    const tooltipList = [...tooltipTriggerList].map(
        (tooltipTriggerEl) => new bootstrap.Tooltip(tooltipTriggerEl)
    );

    /* popover  */
    const popoverTriggerList = document.querySelectorAll(
        '[data-bs-toggle="popover"]'
    );
    const popoverList = [...popoverTriggerList].map(
        (popoverTriggerEl) => new bootstrap.Popover(popoverTriggerEl)
    );

    /* breadcrumb date range picker */
    const today = new Date();
    const startDate = today.toISOString().split("T")[0];
    const endDate = new Date(today);
    endDate.setDate(today.getDate() + 30);
    const endDateFormatted = endDate.toISOString().split("T")[0];

    flatpickr("#daterange", {
        mode: "range",
        dateFormat: "Y-m-d",
        defaultDate: [startDate, endDateFormatted],
        onReady: function (selectedDates, dateStr, instance) {
            updateInputDisplay([startDate, endDateFormatted], instance);
        },
        onChange: function (selectedDates, dateStr, instance) {
            updateInputDisplay(selectedDates, instance);
        },
    });

    function updateInputDisplay(dates, instance) {
        if (dates.length === 2) {
            const startDateFormatted = formatDate(dates[0]);
            const endDateFormatted = formatDate(dates[1]);
            instance.input.value = `${startDateFormatted} to ${endDateFormatted}`;
        } else {
            instance.input.value = "";
        }
    }

    function formatDate(dateString) {
        const date = new Date(dateString);
        const day = String(date.getDate()).padStart(2, "0");
        const month = date.toLocaleString("default", {month: "short"});
        const year = date.getFullYear();
        return `${day}, ${month} ${year}`;
    }

    /* breadcrumb date range picker */

    if (document.querySelector("#switcher-canvas")) {
        // switcher color pickers
        const pickrContainerPrimary = document.querySelector(
            ".pickr-container-primary"
        );
        const themeContainerPrimary = document.querySelector(
            ".theme-container-primary"
        );
        const pickrContainerBackground = document.querySelector(
            ".pickr-container-background"
        );
        const themeContainerBackground = document.querySelector(
            ".theme-container-background"
        );

        /* for theme primary */
        const nanoThemes = [
            [
                "nano",
                {
                    defaultRepresentation: "RGB",
                    components: {
                        preview: true,
                        opacity: false,
                        hue: true,
                        interaction: {
                            hex: false,
                            rgba: true,
                            hsva: false,
                            input: true,
                            clear: false,
                            save: false,
                        },
                    },
                },
            ],
        ];
        const nanoButtons = [];
        let nanoPickr = null;
        for (const [theme, config] of nanoThemes) {
            const button = document.createElement("button");
            button.innerHTML = theme;
            nanoButtons.push(button);

            button.addEventListener("click", () => {
                const el = document.createElement("p");
                pickrContainerPrimary.appendChild(el);

                if (nanoPickr) {
                    nanoPickr.destroyAndRemove();
                }

                for (const btn of nanoButtons) {
                    btn.classList[btn === button ? "add" : "remove"]("active");
                }

                nanoPickr = new Pickr(
                    Object.assign(
                        {
                            el,
                            theme,
                            default: "#985ffd",
                        },
                        config
                    )
                );

                nanoPickr.on("changestop", (source, instance) => {
                    let color = instance.getColor().toRGBA();
                    let html = document.querySelector("html");
                    html.style.setProperty(
                        "--primary-rgb",
                        `${Math.floor(color[0])}, ${Math.floor(color[1])}, ${Math.floor(
                            color[2]
                        )}`
                    );
                    localStorage.setItem(
                        "primaryRGB",
                        `${Math.floor(color[0])}, ${Math.floor(color[1])}, ${Math.floor(
                            color[2]
                        )}`
                    );
                });
            });

            themeContainerPrimary.appendChild(button);
        }
        nanoButtons[0].click();
        /* for theme primary */

        /* for theme background */
        const nanoThemes1 = [
            [
                "nano",
                {
                    defaultRepresentation: "RGB",
                    components: {
                        preview: true,
                        opacity: false,
                        hue: true,
                        interaction: {
                            hex: false,
                            rgba: true,
                            hsva: false,
                            input: true,
                            clear: false,
                            save: false,
                        },
                    },
                },
            ],
        ];
        const nanoButtons1 = [];
        let nanoPickr1 = null;
        for (const [theme, config] of nanoThemes1) {
            const button = document.createElement("button");
            button.innerHTML = theme;
            nanoButtons1.push(button);

            button.addEventListener("click", () => {
                const el = document.createElement("p");
                pickrContainerBackground.appendChild(el);

                if (nanoPickr1) {
                    nanoPickr1.destroyAndRemove();
                }

                for (const btn of nanoButtons1) {
                    btn.classList[btn === button ? "add" : "remove"]("active");
                }

                nanoPickr1 = new Pickr(
                    Object.assign(
                        {
                            el,
                            theme,
                            default: "#985ffd",
                        },
                        config
                    )
                );

                nanoPickr1.on("changestop", (source, instance) => {
                    let color = instance.getColor().toRGBA();
                    let htmlEl = document.querySelector("html");
                    htmlEl.style.setProperty(
                        "--body-bg-rgb",
                        `${color[0]}, ${color[1]}, ${color[2]}`
                    );
                    htmlEl.style.setProperty(
                        "--body-bg-rgb2",
                        `${color[0] + 14}, ${color[1] + 14}, ${color[2] + 14}`
                    );
                    htmlEl.style.setProperty(
                        "--light-rgb",
                        `${color[0] + 14}, ${color[1] + 14}, ${color[2] + 14}`
                    );
                    htmlEl.style.setProperty(
                        "--form-control-bg",
                        `rgb(${color[0] + 14}, ${color[1] + 14}, ${color[2] + 14})`
                    );
                    htmlEl.style.setProperty(
                        "--gray-3",
                        `rgb(${color[0] + 14}, ${color[1] + 14}, ${color[2] + 14})`
                    );
                    localStorage.removeItem("bgtheme");
                    localStorage.setItem(
                        "bodyBgRGB",
                        `${color[0]}, ${color[1]}, ${color[2]}`
                    );
                    localStorage.setItem(
                        "bodylightRGB",
                        `${color[0] + 14}, ${color[1] + 14}, ${color[2] + 14}`
                    );
                });
            });
            themeContainerBackground.appendChild(button);
        }
        nanoButtons1[0].click();
        /* for theme background */
    }

    /* Choices JS */
    document.addEventListener("DOMContentLoaded", function () {
        var genericExamples = document.querySelectorAll("[data-trigger]");
        for (let i = 0; i < genericExamples.length; ++i) {
            var element = genericExamples[i];
            new Choices(element, {
                allowHTML: true,
                placeholderValue: "This is a placeholder set in the config",
                searchPlaceholderValue: "Search",
            });
        }
    });
    /* Choices JS */

    /* footer year */
    document.getElementById("year").innerHTML = new Date().getFullYear();
    /* footer year */

    /* node waves */
    Waves.attach(".btn-wave", ["waves-light"]);
    Waves.init();
    /* node waves */

    /* card with close button */
    let DIV_CARD = ".card";
    let cardRemoveBtn = document.querySelectorAll(
        '[data-bs-toggle="card-remove"]'
    );
    cardRemoveBtn.forEach((ele) => {
        ele.addEventListener("click", function (e) {
            e.preventDefault();
            let $this = this;
            let card = $this.closest(DIV_CARD);
            card.remove();
            return false;
        });
    });
    /* card with close button */

    /* card with fullscreen */
    let cardFullscreenBtn = document.querySelectorAll(
        '[data-bs-toggle="card-fullscreen"]'
    );
    cardFullscreenBtn.forEach((ele) => {
        ele.addEventListener("click", function (e) {
            let $this = this;
            let card = $this.closest(DIV_CARD);
            card.classList.toggle("card-fullscreen");
            card.classList.remove("card-collapsed");
            e.preventDefault();
            return false;
        });
    });
    /* card with fullscreen */

    /* count-up */
    var i = 1;
    setInterval(() => {
        document.querySelectorAll(".count-up").forEach((ele) => {
            if (ele.getAttribute("data-count") >= i) {
                i = i + 1;
                ele.innerText = i;
            }
        });
    }, 10);
    /* count-up */

    /* Progressbar Top */
    window.addEventListener("scroll", () => {
        var widnowScroll =
                document.body.scrollTop || document.documentElement.scrollTop,
            height =
                document.documentElement.scrollHeight -
                document.documentElement.clientHeight,
            scrollAmount = (widnowScroll / height) * 100;
        document.querySelector(".progress-top-bar").style.width = scrollAmount + "%";
    });
    /* Progressbar Top */

    /* back to top */
    const scrollToTop = document.querySelector(".scrollToTop");
    const $rootElement = document.documentElement;
    const $body = document.body;
    window.onscroll = () => {
        const scrollTop = window.scrollY || window.pageYOffset;
        const clientHt = $rootElement.scrollHeight - $rootElement.clientHeight;
        if (window.scrollY > 100) {
            scrollToTop.style.display = "flex";
        } else {
            scrollToTop.style.display = "none";
        }
    };
    scrollToTop.onclick = () => {
        window.scrollTo(0, 0);
    };
    /* back to top */

    /* header dropdowns scroll */
    var myHeadernotification = document.getElementById(
        "header-notification-scroll"
    );
    new SimpleBar(myHeadernotification, {autoHide: true});

    var myHeaderCart = document.getElementById("header-cart-items-scroll");
    new SimpleBar(myHeaderCart, {autoHide: true});
    /* header dropdowns scroll */

    const autoCompleteJS = new autoComplete({
        selector: "#header-search",
        data: {
            src: [
                "How do plants adapt to different environments?",
                "What makes the ocean's tides rise and fall?",
                "How do our brains process emotions?",
                "What factors contribute to the creation of a rainbow?",
                "Who invented the telephone?",
                "What role does the moon play in Earth's ecosystem?",
                "How do animals communicate with each other?",
                "What causes earthquakes to happen?",
                "What is the significance of the Great Barrier Reef?",
                "How do human bones regenerate after an injury?",
            ],
            cache: true,
        },
        resultItem: {
            highlight: true,
        },
        events: {
            input: {
                selection: (event) => {
                    const selection = event.detail.selection.value;
                    autoCompleteJS.input.value = selection;
                },
            },
        },
    });
})();

/* full screen */
var elem = document.documentElement;
window.openFullscreen = function () {
    let open = document.querySelector(".full-screen-open");
    let close = document.querySelector(".full-screen-close");

    if (
        !document.fullscreenElement &&
        !document.webkitFullscreenElement &&
        !document.msFullscreenElement
    ) {
        if (elem.requestFullscreen) {
            elem.requestFullscreen();
        } else if (elem.webkitRequestFullscreen) {
            /* Safari */
            elem.webkitRequestFullscreen();
        } else if (elem.msRequestFullscreen) {
            /* IE11 */
            elem.msRequestFullscreen();
        }
        close.classList.add("d-block");
        close.classList.remove("d-none");
        open.classList.add("d-none");
    } else {
        if (document.exitFullscreen) {
            document.exitFullscreen();
        } else if (document.webkitExitFullscreen) {
            /* Safari */
            document.webkitExitFullscreen();
        } else if (document.msExitFullscreen) {
            /* IE11 */
            document.msExitFullscreen();
        }
        close.classList.remove("d-block");
        open.classList.remove("d-none");
        close.classList.add("d-none");
        open.classList.add("d-block");
    }
};
/* full screen */

/* toggle switches */
let customSwitch = document.querySelectorAll(".toggle");
customSwitch.forEach((e) =>
    e.addEventListener("click", () => {
        e.classList.toggle("on");
    })
);
/* toggle switches */

/* header dropdown close button */

/* for cart dropdown */
const headerbtn = document.querySelectorAll(".dropdown-item-close");
headerbtn.forEach((button) => {
    button.addEventListener("click", (e) => {
        e.preventDefault();
        e.stopPropagation();
        button.parentNode.parentNode.parentNode.parentNode.parentNode.remove();
        document.getElementById("cart-data").innerText = `${document.querySelectorAll(
            ".dropdown-item-close"
        ).length} `;
        document.getElementById("cart-icon-badge").innerText = `${document.querySelectorAll(
            ".dropdown-item-close"
        ).length}`;
        console.log(
            document.getElementById("header-cart-items-scroll").children.length
        );
        if (document.querySelectorAll(".dropdown-item-close").length == 0) {
            let elementHide = document.querySelector(".empty-header-item");
            let elementShow = document.querySelector(".empty-item");
            elementHide.classList.add("d-none");
            elementShow.classList.remove("d-none");
        }
    });
});
/* for cart dropdown */

/* for notifications dropdown */
const headerbtn1 = document.querySelectorAll(".dropdown-item-close1");
headerbtn1.forEach((button) => {
    button.addEventListener("click", (e) => {
        e.preventDefault();
        e.stopPropagation();
        button.parentNode.parentNode.parentNode.parentNode.remove();
        document.getElementById("notifiation-data").innerText = `${document.querySelectorAll(
            ".dropdown-item-close1"
        ).length} Unread`;
        if (document.querySelectorAll(".dropdown-item-close1").length == 0) {
            let elementHide1 = document.querySelector(".empty-header-item1");
            let elementShow1 = document.querySelector(".empty-item1");
            elementHide1.classList.add("d-none");
            elementShow1.classList.remove("d-none");
        }
    });
});
/* for notifications dropdown */

/* for cart items quantity */
var value = 1,
    minValue = 0,
    maxValue = 30;

let productMinusBtn = document.querySelectorAll(".product-quantity-minus");
let productPlusBtn = document.querySelectorAll(".product-quantity-plus");
productMinusBtn.forEach((element) => {
    element.onclick = () => {
        value = Number(element.parentElement.childNodes[3].value);
        if (value > minValue) {
            value = Number(element.parentElement.childNodes[3].value) - 1;
            element.parentElement.childNodes[3].value = value;
        }
    };
});
productPlusBtn.forEach((element) => {
    element.onclick = () => {
        if (value < maxValue) {
            value = Number(element.parentElement.childNodes[3].value) + 1;
            element.parentElement.childNodes[3].value = value;
        }
    };
});
/* for cart items quantity */
