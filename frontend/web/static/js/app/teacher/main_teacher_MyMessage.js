require.config({
    baseUrl: '/static/js/',
    paths: {
        jquery: 'jquery',
        teacher_MyMessage:'app/teacher/teacher_MyMessage'
    }
});

require(['teacher_MyMessage']);
