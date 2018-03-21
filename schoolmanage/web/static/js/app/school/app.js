require.config({
    baseUrl: '/static/js/',
    paths: {
        jquery: 'jquery',
        school_mag:'app/school/school_mag'
    }
});
require(['school_mag']);
