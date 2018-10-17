<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package WordPress
 */
get_header();
the_brand_header();
?>
    <style>
        .error{
            color: #002e5d;
            font-family: "Vitesse A", "Vitesse B";
            font-size: 40px;
        }
    </style>
    <center><h2 class="error">Sorry the page your are looking for is not found</h2></center>
<?php get_footer();

