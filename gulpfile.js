/**
 * GetWord | gulp file
 */

const gulp = require("gulp");
const concat = require("gulp-concat");
const cleanCss = require("gulp-clean-css");
const uglify = require("gulp-uglify");

gulp.task("jquery", () => {
    return gulp.src("bower_components/jquery/dist/jquery.min.js")
        .pipe(gulp.dest("assets/dest/js"));
});

gulp.task("bootstrap-css", () => {
    return gulp.src("bower_components/bootstrap/dist/css/bootstrap.min.css")
        .pipe(gulp.dest("assets/dest/css"));
});

gulp.task("bootstrap-js", () => {
    return gulp.src("bower_components/bootstrap/dist/js/bootstrap.min.js")
        .pipe(gulp.dest("assets/dest/js"));
});

gulp.task("index-css", () => {
    return gulp.src("assets/src/css/index.css")
        .pipe(concat("index.min.css"))
        .pipe(cleanCss())
        .pipe(gulp.dest("assets/dest/css"));
});

gulp.task("index-js", () => {
    return gulp.src("assets/src/js/index.js")
        .pipe(concat("index.min.js"))
        .pipe(uglify())
        .pipe(gulp.dest("assets/dest/js"));
});

gulp.task("watch", () => {
    gulp.watch("bower_components/jquery/jquery.min.js", gulp.parallel("jquery"));

    gulp.watch("bower_components/bootstrap/dist/css/bootstrap.min.css", gulp.parallel("bootstrap-css"));
    gulp.watch("bower_components/bootstrap/dist/js/bootstrap.min.js", gulp.parallel("bootstrap-js"));

    gulp.watch("assets/src/css/index.css", gulp.parallel("index-css"));
    gulp.watch("assets/src/js/index.js", gulp.parallel("index-js"));
});

gulp.task("default", gulp.parallel("jquery", "bootstrap-css", "bootstrap-js", "index-css", "index-js"));
