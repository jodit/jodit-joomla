module.exports = function override(config, env) {
    if (!config.externals) {
        config.externals = {};
    }
    if (process.env.NODE_ENV === 'production') {
        config.externals.jodit = 'Jodit';
    }
    return config;
};