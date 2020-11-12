/**
 * grunt exec:dvcampus_luma_uk_ua && grunt less:dvcampus_luma_uk_ua && grunt watch
 * grunt exec:dvcampus_luma_en_us && grunt less:dvcampus_luma_en_us && grunt watch
 */
module.exports = {
    dvcampus_luma_uk_ua: {
        area: 'frontend',
        name: 'DVCampus/luma',
        locale: 'uk_UA',
        files: [
            'css/styles-m',
            'css/styles-l'
        ],
        dsl: 'less'
    },
    dvcampus_luma_en_us: {
        area: 'frontend',
        name: 'DVCampus/luma',
        locale: 'en_US',
        files: [
            'css/styles-m',
            'css/styles-l'
        ],
        dsl: 'less'
    }
};
