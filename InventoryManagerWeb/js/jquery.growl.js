var _createClass = function () {
    function defineProperties(target, props) {
        for (var i = 0; i < props.length; i++) {
            var descriptor = props[i];
            descriptor.enumerable = descriptor.enumerable || false;
            descriptor.configurable = true;
            if ("value" in descriptor)
                descriptor.writable = true;
            Object.defineProperty(target, descriptor.key, descriptor);
        }
    }
    return function (Constructor, protoProps, staticProps) {
        if (protoProps)
            defineProperties(Constructor.prototype, protoProps);
        if (staticProps)
            defineProperties(Constructor, staticProps);
        return Constructor;
    };
}();

function _classCallCheck(instance, Constructor) {
    if (!(instance instanceof Constructor)) {
        throw new TypeError("Cannot call a class as a function");
    }
}

(function () {
    
    "use strict";

    var $, Animation, Growl;

    $ = jQuery;

    Animation = function () {
        var Animation = function () {
            function Animation() {
                _classCallCheck(this, Animation);
            }

            _createClass(Animation, null, [{
                    key: "transition",
                    value: function transition($el) {
                        var el, ref, result, type;
                        el = $el[0];
                        ref = this.transitions;
                        for (type in ref) {
                            result = ref[type];
                            if (el.style[type] != null) {
                                return result;
                            }
                        }
                    }
                }]);

            return Animation;
        }();

        ;

        Animation.transitions = {
            "webkitTransition": "webkitTransitionEnd",
            "mozTransition": "mozTransitionEnd",
            "oTransition": "oTransitionEnd",
            "transition": "transitionend"
        };

        return Animation;
    }();

    Growl = function () {
        var Growl = function () {
            _createClass(Growl, null, [{
                    key: "growl",
                    value: function growl() {
                        var settings = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {};

                        return new Growl(settings);
                    }
                }]);

            function Growl() {
                var settings = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {};

                _classCallCheck(this, Growl);

                this.render = this.render.bind(this);
                this.bind = this.bind.bind(this);
                this.unbind = this.unbind.bind(this);
                this.mouseEnter = this.mouseEnter.bind(this);
                this.mouseLeave = this.mouseLeave.bind(this);
                this.click = this.click.bind(this);
                this.close = this.close.bind(this);
                this.cycle = this.cycle.bind(this);
                this.waitAndDismiss = this.waitAndDismiss.bind(this);
                this.present = this.present.bind(this);
                this.dismiss = this.dismiss.bind(this);
                this.remove = this.remove.bind(this);
                this.animate = this.animate.bind(this);
                this.$growls = this.$growls.bind(this);
                this.$growl = this.$growl.bind(this);
                this.html = this.html.bind(this);
                this.content = this.content.bind(this);
                this.container = this.container.bind(this);
                this.settings = $.extend({}, Growl.settings, settings);
                this.initialize(this.settings.location);
                this.render();
            }

            _createClass(Growl, [{
                    key: "initialize",
                    value: function initialize(location) {
                        var id;
                        id = 'growls-' + location;
                        return $('body:not(:has(#' + id + '))').append('<div id="' + id + '" />');
                    }
                }, {
                    key: "render",
                    value: function render() {
                        var $growl;
                        $growl = this.$growl();
                        this.$growls(this.settings.location).append($growl);
                        if (this.settings.fixed) {
                            this.present();
                        } else {
                            this.cycle();
                        }
                    }
                }, {
                    key: "bind",
                    value: function bind() {
                        var $growl = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : this.$growl();

                        $growl.on("click", this.click);
                        if (this.settings.delayOnHover) {
                            $growl.on("mouseenter", this.mouseEnter);
                            $growl.on("mouseleave", this.mouseLeave);
                        }
                        return $growl.on("contextmenu", this.close).find("." + this.settings.namespace + "-close").on("click", this.close);
                    }
                }, {
                    key: "unbind",
                    value: function unbind() {
                        var $growl = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : this.$growl();

                        $growl.off("click", this.click);
                        if (this.settings.delayOnHover) {
                            $growl.off("mouseenter", this.mouseEnter);
                            $growl.off("mouseleave", this.mouseLeave);
                        }
                        return $growl.off("contextmenu", this.close).find("." + this.settings.namespace + "-close").off("click", this.close);
                    }
                }, {
                    key: "mouseEnter",
                    value: function mouseEnter(event) {
                        var $growl;
                        $growl = this.$growl();
                        return $growl.stop(true, true);
                    }
                }, {
                    key: "mouseLeave",
                    value: function mouseLeave(event) {
                        return this.waitAndDismiss();
                    }
                }, {
                    key: "click",
                    value: function click(event) {
                        if (this.settings.url != null) {
                            event.preventDefault();
                            event.stopPropagation();
                            return window.open(this.settings.url);
                        }
                    }
                }, {
                    key: "close",
                    value: function close(event) {
                        var $growl;
                        event.preventDefault();
                        event.stopPropagation();
                        $growl = this.$growl();
                        return $growl.stop().queue(this.dismiss).queue(this.remove);
                    }
                }, {
                    key: "cycle",
                    value: function cycle() {
                        var $growl;
                        $growl = this.$growl();
                        return $growl.queue(this.present).queue(this.waitAndDismiss());
                    }
                }, {
                    key: "waitAndDismiss",
                    value: function waitAndDismiss() {
                        var $growl;
                        $growl = this.$growl();
                        return $growl.delay(this.settings.duration).queue(this.dismiss).queue(this.remove);
                    }
                }, {
                    key: "present",
                    value: function present(callback) {
                        var $growl;
                        $growl = this.$growl();
                        this.bind($growl);
                        return this.animate($growl, this.settings.namespace + "-incoming", 'out', callback);
                    }
                }, {
                    key: "dismiss",
                    value: function dismiss(callback) {
                        var $growl;
                        $growl = this.$growl();
                        this.unbind($growl);
                        return this.animate($growl, this.settings.namespace + "-outgoing", 'in', callback);
                    }
                }, {
                    key: "remove",
                    value: function remove(callback) {
                        this.$growl().remove();
                        return typeof callback === "function" ? callback() : void 0;
                    }
                }, {
                    key: "animate",
                    value: function animate($element, name) {
                        var direction = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : 'in';
                        var callback = arguments[3];

                        var transition;
                        transition = Animation.transition($element);
                        $element[direction === 'in' ? 'removeClass' : 'addClass'](name);
                        $element.offset().position;
                        $element[direction === 'in' ? 'addClass' : 'removeClass'](name);
                        if (callback == null) {
                            return;
                        }
                        if (transition != null) {
                            $element.one(transition, callback);
                        } else {
                            callback();
                        }
                    }
                }, {
                    key: "$growls",
                    value: function $growls(location) {
                        var base;
                        if (this.$_growls == null) {
                            this.$_growls = [];
                        }
                        return (base = this.$_growls)[location] != null ? base[location] : base[location] = $('#growls-' + location);
                    }
                }, {
                    key: "$growl",
                    value: function $growl() {
                        return this.$_growl != null ? this.$_growl : this.$_growl = $(this.html());
                    }
                }, {
                    key: "html",
                    value: function html() {
                        return this.container(this.content());
                    }
                }, {
                    key: "content",
                    value: function content() {
                        return "<div class='" + this.settings.namespace + "-close'>" + this.settings.close + "</div>\n<div class='" + this.settings.namespace + "-title'>" + this.settings.title + "</div>\n<div class='" + this.settings.namespace + "-message'>" + this.settings.message + "</div>";
                    }
                }, {
                    key: "container",
                    value: function container(content) {
                        return "<div class='" + this.settings.namespace + " " + this.settings.namespace + "-" + this.settings.style + " " + this.settings.namespace + "-" + this.settings.size + "'>\n  " + content + "\n</div>";
                    }
                }]);

            return Growl;
        }();

        ;

        Growl.settings = {
            namespace: 'growl',
            duration: 3200,
            close: "&#215;",
            location: "default",
            style: "default",
            size: "medium",
            delayOnHover: true
        };

        return Growl;
    }();

    this.Growl = Growl;

    $.growl = function () {
        var options = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {};

        return Growl.growl(options);
    };

    $.growl.error = function () {
        var options = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {};

        var settings;
        settings = {
            title: "Error!",
            style: "error"
        };
        return $.growl($.extend(settings, options));
    };

    $.growl.notice = function () {
        var options = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {};

        var settings;
        settings = {
            title: "Notice!",
            style: "notice"
        };
        return $.growl($.extend(settings, options));
    };

    $.growl.warning = function () {
        var options = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {};

        var settings;
        settings = {
            title: "Warning!",
            style: "warning"
        };
        return $.growl($.extend(settings, options));
    };
}).call(this);