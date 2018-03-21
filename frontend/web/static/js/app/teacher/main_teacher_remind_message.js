require.config({
    baseUrl: '../static/js/',
    paths: {
        jquery: 'jquery',
        teacher_remind_message:'app/teacher/teacher_remind_message'
        //popBox:'module/popBox'
    }
});
require(['teacher_remind_message']);
