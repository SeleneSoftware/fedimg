/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// JS applications
import "./styles/kiro/foundation.js";
import "./styles/kiro/jquery.slim.js";
import "./styles/kiro/outofview.js";
import "./styles/kiro/picturefill.js";
import "./styles/kiro/what-input.js";

// any CSS you import will output into a single css file (app.css in this case)
import "./styles/app.kiro.scss";

// start the Stimulus application
import "./bootstrap";

$(function () {
    $('a.smooth-scroll[href*="#"]:not([href="#"])').click(function () {
        if (
            location.pathname.replace(/^\//, "") ==
                this.pathname.replace(/^\//, "") &&
            location.hostname == this.hostname
        ) {
            var target = $(this.hash);
            target = target.length
                ? target
                : $("[name=" + this.hash.slice(1) + "]");
            if (target.length) {
                $("html,body").animate(
                    {
                        scrollTop: target.offset().top,
                    },
                    1000
                );
                return false;
            }
        }
    });
});
