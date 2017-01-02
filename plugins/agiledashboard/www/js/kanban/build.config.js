/**
 * This file/module contains all configuration for the build process.
 */
module.exports = {
    /**
     * The `build_dir` folder is where our projects are compiled during
     * development and the `compile_dir` folder is where our app resides once it's
     * completely built.
     */
    build_dir  : 'build',
    compile_dir: 'bin',

    /**
     * This is a collection of file patterns that refer to our app code (the
     * stuff in `src/`). These file paths are used in the configuration of
     * build tasks. `js` is all project javascript, less tests. `ctpl` contains
     * our reusable components' (`src/common`) template HTML files, while
     * `atpl` contains the same, but for our app's code. `html` is just our
     * main HTML file, `less` is our main stylesheet, and `unit` contains our
     * app's unit tests.
     */
    app_files: {
        modules: [
            'src/**/*.js',
            '!src/**/*.spec.js',
            '!src/**/*-service.js',
            '!src/**/*-value.js',
            '!src/**/*-constant.js',
            '!src/**/*-controller.js',
            '!src/**/*-config.js',
            '!src/**/*-directive.js',
            '!src/**/*-factory.js',
            '!src/**/*-filter.js',
            '!src/**/*-run.js'
        ],
        js: [
            'src/**/*-service.js',
            'src/**/*-value.js',
            'src/**/*-constant.js',
            'src/**/*-controller.js',
            'src/**/*-config.js',
            'src/**/*-directive.js',
            'src/**/*-factory.js',
            'src/**/*-filter.js',
            'src/**/*-run.js',
            '!src/**/*.spec.js'
        ],
        jsunit: ['src/**/*.spec.js'],

        atpl: ['src/app/**/*.tpl.html'],
        scss: 'src/app/kanban.scss'
    },

    /**
     * This is the same as `app_files`, except it contains patterns that
     * reference vendor code (`vendor/`) that we need to place into the build
     * process somewhere. While the `app_files` property ensures all
     * standardized files are collected for compilation, it is the user's job
     * to ensure non-standardized (i.e. vendor-related) files are handled
     * appropriately in `vendor_files.js`.
     *
     * The `vendor_files.js` property holds files to be automatically
     * concatenated and minified with our project source files.
     */
    vendor_files: {
        js: [
            'vendor/angular/angular.js',
            'vendor/lodash/dist/lodash.min.js',
            'vendor/angular-gettext/dist/angular-gettext.min.js',
            'vendor/angular-ui-router/release/angular-ui-router.js',
            'vendor/moment/min/moment.min.js',
            'vendor/moment/locale/en-gb.js',
            'vendor/moment/locale/fr.js',
            'vendor/angular-moment/angular-moment.min.js',
            'vendor/angular-sanitize/angular-sanitize.min.js',
            'vendor/restangular/dist/restangular.js',
            'vendor/angular-ui-tree/dist/angular-ui-tree.min.js',
            'vendor/angular-ui-bootstrap-bower/ui-bootstrap-tpls.js',
            'vendor/angular-animate/angular-animate.min.js',
            'vendor/ng-scrollbar/dist/ng-scrollbar.min.js',
            'vendor/angular-base64-upload/dist/angular-base64-upload.js',
            'vendor/angular-ckeditor/angular-ckeditor.js',
            'vendor/angular-bootstrap-datetimepicker/src/js/datetimepicker.js',
            'vendor/angular-filter/dist/angular-filter.min.js',
            'vendor/angular-ui-select/dist/select.js',
            'vendor/artifact-modal/dist/tuleap-artifact-modal.js',
            'vendor/angular-socket-io/socket.js',
            'vendor/socket.io-client/socket.io.js',
            'vendor/angular-locker/dist/angular-locker.min.js',
            'vendor/dragular/dist/dragular.js',
            'vendor/angular-jwt/dist/angular-jwt.min.js',
            'vendor/striptagsjs/striptags.js'
        ],
        assets: [
            'vendor/artifact-modal/dist/assets/artifact_attachment_default.png',
            'vendor/artifact-modal/dist/assets/loader-mini.gif'
        ]
    }
};
