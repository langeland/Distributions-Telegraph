"use strict";

var system = require('system');
var webPage = require('webpage');
var page = webPage.create();

page.open(system.args[1], function start(status) {
    page.render(system.args[2], {format: 'png'});
    phantom.exit();
});