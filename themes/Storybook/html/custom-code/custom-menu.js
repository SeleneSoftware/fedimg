$(function() {
    function updateMenu() {
        // Open the menu entry
        var page = window.location.pathname.split("/").pop();
        page = page ? page : 'index.html';
        $('[data-page-name="' + page + '"]').closest('details').prop('open', true);

        // Set as active the menu from the location hash or the first one of the page
        $('.menu-item-link').removeClass('active');
        var hash = window.location.hash;
        if(hash) {
            $('.menu-item-link a[href="' + page + hash + '"]').closest('.menu-item-link').addClass('active');
        }
        else {
            $('[data-page-name="' + page + '"]').closest('details').find('.menu-item-link:first-child').addClass('active');
        }
    }
    
    function toggleMenu() {
        $('nav.menu-container').toggleClass('show-menu');
        $('nav.menu-container .menu-items-wrapper').toggleClass('show-menu');
        $('.title-section').toggleClass('show-menu');
    }

    $(document).ready(function(){
        // Mobile navigation
        $('nav.menu-container .menu-icon').click(function(e) {
            toggleMenu();
            e.preventDefault();
            return false;
        });

        // Click to update the menu
        $('.menu-item-link a').click(function(){
            toggleMenu();
        });

        // Active hashes based on appear (using jquery.appear.js)
        $('.section-content-guide').appear();
        $('.section-content-guide').on('appear', function(event) {
            $('.menu-item-link').removeClass('active');
            var page = window.location.pathname.split("/").pop();
            page = page ? page : 'index.html';
            var hash = "#" + $(this).find('.title-section').attr('id');
            var $anchor = $('.menu-item-link a[href="' + page + hash + '"]');
            if(!$anchor.length) {
                $anchor = $('.menu-item-link a[href="' + page + '"]');
            }
            $anchor.closest('.menu-item-link').addClass('active');
        });

        // Update the menu on load
        updateMenu();
        
        // Add class for styles on html loaded
        $('html').addClass('loaded');
        
        //Calculate viewport height for mobile devices
        var calculateHeight = function() {
            document.documentElement.style.setProperty('--viewport-height', window.innerHeight * 0.01 + 'px');
        }
        window.addEventListener('resize', calculateHeight);
        calculateHeight();
    });
});