/**
 * grunt exec:dvcampus_luma_en_us && grunt less:dvcampus_luma_en_us
 */
module.exports = {
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
