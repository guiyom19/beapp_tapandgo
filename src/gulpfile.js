var gulp = require('gulp');
var less = require('./');

gulp.task('less', function(){
  gulp.src('./less/style.less')
  .pipe(less())
  .pipe(gulp.dest('../public/css/'));
});

gulp.task('default', ['less']);
