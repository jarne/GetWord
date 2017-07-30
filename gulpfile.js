/**
 * Created by jarne on 28.07.17.
 */

var gulp = require("gulp");
var concat = require("gulp-concat");
var sass = require("gulp-sass");
var replace = require("gulp-replace");
var cleanCss = require("gulp-clean-css");
var uglify = require("gulp-uglify");

gulp.task("jquery", function() {
    return gulp.src("bower_components/jquery/dist/jquery.min.js")
        .pipe(gulp.dest("assets/dest/js"))
});

gulp.task("materialize-css", function() {
    return gulp.src("bower_components/materialize/sass/materialize.scss")
        .pipe(replace("@import \"components/variables\";", "@import \"../../../assets/src/sass/components/variables\";"))
        .pipe(sass())
        .pipe(cleanCss())
        .pipe(concat("materialize.min.css"))
        .pipe(gulp.dest("assets/dest/css"))
});

gulp.task("materialize-js", function() {
    return gulp.src("bower_components/materialize/dist/js/materialize.min.js")
        .pipe(gulp.dest("assets/dest/js"))
});

gulp.task("materialize-fonts", function() {
    return gulp.src("bower_components/materialize/dist/fonts/*/*")
        .pipe(gulp.dest("assets/dest/fonts"))
});

gulp.task("index-css", function() {
    return gulp.src("assets/src/css/index.css")
        .pipe(concat("index.min.css"))
        .pipe(cleanCss())
        .pipe(gulp.dest("assets/dest/css"))
});

gulp.task("index-js", function() {
    return gulp.src("assets/src/js/index.js")
        .pipe(concat("index.min.js"))
        .pipe(uglify())
        .pipe(gulp.dest("assets/dest/js"))
});

gulp.task("watch", function() {
    gulp.watch("bower_components/jquery/jquery.min.js", ["jquery"]);

    gulp.watch("assets/src/sass/components/_variables.scss", ["materialize-css"]);
    gulp.watch("bower_components/materialize/dist/js/materialize.min.js", ["materialize-js"]);
    gulp.watch("bower_components/materialize/dist/fonts/*/*", ["materialize-fonts"]);

    gulp.watch("assets/src/css/index.css", ["index-css"]);
    gulp.watch("assets/src/js/index.js", ["index-js"]);
});

gulp.task("default", ["jquery", "materialize-css", "materialize-js", "materialize-fonts", "index-css", "index-js"]);