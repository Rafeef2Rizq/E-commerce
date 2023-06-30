import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
            input: ["resources/sass/app.scss",
             "resources/js/app.js",
             "resources/assert/sass/pages/shop.scss",
             "resources/assert/sass/pages/breadcrumbs.scss",
             "resources/assert/sass/pages/product.scss",
             "resources/assert/sass/pages/might-like.scss",
             "resources/assert/sass/pages/sidebar.scss",
             "resources/assert/sass/pages/cart.scss",
             "resources/assert/sass/pages/header.scss",
             "resources/assert/sass/pages/alert.scss",
             "resources/assert/sass/pages/checkout.scss",
             "resources/assert/sass/pages/form.scss",
             "resources/assert/sass/pages/thankyou.scss",
             "resources/assert/sass/pages/buttons.scss",
             "resources/assert/sass/pages/pagination.scss",
            // "resources/assert/sass/pages/landing-page.scss",
            ], // add scss file
            refresh: true,
        }),
    ],
});