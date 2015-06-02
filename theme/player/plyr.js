! function(e) {
    "use strict";

    function t() {
        var e = ["<div class='player-controls'>", "<div class='player-progress'>", "<label for='seek{id}' class='sr-only'>Seek</label>", "<input id='seek{id}' class='player-progress-seek' type='range' min='0' max='100' step='0.5' value='0' data-player='seek'>", "<progress class='player-progress-played' max='100' value='0'>", "<span>0</span>% played", "</progress>", "<progress class='player-progress-buffer' max='100' value='0'>", "<span>0</span>% buffered", "</progress>", "</div>", "<span class='player-controls-left'>"];
        return a(F.controls, "restart") && e.push("<button type='button' data-player='restart'>", "<svg><use xlink:href='#icon-restart'></use></svg>", "<span class='sr-only'>Restart</span>", "</button>"), a(F.controls, "rewind") && e.push("<button type='button' data-player='rewind'>", "<svg><use xlink:href='#icon-rewind'></use></svg>", "<span class='sr-only'>Rewind {seektime} secs</span>", "</button>"), a(F.controls, "play") && e.push("<button type='button' data-player='play'>", "<svg><use xlink:href='#icon-play'></use></svg>", "<span class='sr-only'>Play</span>", "</button>", "<button type='button' data-player='pause'>", "<svg><use xlink:href='#icon-pause'></use></svg>", "<span class='sr-only'>Pause</span>", "</button>"), a(F.controls, "fast-forward") && e.push("<button type='button' data-player='fast-forward'>", "<svg><use xlink:href='#icon-fast-forward'></use></svg>", "<span class='sr-only'>Forward {seektime} secs</span>", "</button>"), a(F.controls, "current-time") && e.push("<span class='player-time'>", "<span class='sr-only'>Current time</span>", "<span class='player-current-time'>00:00</span>", "</span>"), a(F.controls, "duration") && e.push("<span class='player-time'>", "<span class='sr-only'>Duration</span>", "<span class='player-duration'>00:00</span>", "</span>"), e.push("</span>", "<span class='player-controls-right'>"), a(F.controls, "mute") && e.push("<input class='inverted sr-only' id='mute{id}' type='checkbox' data-player='mute'>", "<label id='mute{id}' for='mute{id}'>", "<svg class='icon-muted'><use xlink:href='#icon-muted'></use></svg>", "<svg><use xlink:href='#icon-volume'></use></svg>", "<span class='sr-only'>Toggle Mute</span>", "</label>"), a(F.controls, "volume") && e.push("<label for='volume{id}' class='sr-only'>Volume</label>", "<input id='volume{id}' class='player-volume' type='range' min='0' max='10' value='5' data-player='volume'>"), a(F.controls, "captions") && e.push("<input class='sr-only' id='captions{id}' type='checkbox' data-player='captions'>", "<label for='captions{id}'>", "<svg class='icon-captions-on'><use xlink:href='#icon-captions-on'></use></svg>", "<svg><use xlink:href='#icon-captions-off'></use></svg>", "<span class='sr-only'>Toggle Captions</span>", "</label>"), a(F.controls, "fullscreen") && e.push("<button type='button' data-player='fullscreen'>", "<svg class='icon-exit-fullscreen'><use xlink:href='#icon-exit-fullscreen'></use></svg>", "<svg><use xlink:href='#icon-enter-fullscreen'></use></svg>", "<span class='sr-only'>Toggle Fullscreen</span>", "</button>"), e.push("</span>", "</div>"), e.join("")
    }

    function n(e, t) {
        F.debug && window.console && console[t ? "error" : "log"](e)
    }

    function r() {
        var e, t, n, r = navigator.userAgent,
            s = navigator.appName,
            a = "" + parseFloat(navigator.appVersion),
            o = parseInt(navigator.appVersion, 10);
        return -1 !== navigator.appVersion.indexOf("Windows NT") && -1 !== navigator.appVersion.indexOf("rv:11") ? (s = "IE", a = "11;") : -1 !== (t = r.indexOf("MSIE")) ? (s = "IE", a = r.substring(t + 5)) : -1 !== (t = r.indexOf("Chrome")) ? (s = "Chrome", a = r.substring(t + 7)) : -1 !== (t = r.indexOf("Safari")) ? (s = "Safari", a = r.substring(t + 7), -1 !== (t = r.indexOf("Version")) && (a = r.substring(t + 8))) : -1 !== (t = r.indexOf("Firefox")) ? (s = "Firefox", a = r.substring(t + 8)) : (e = r.lastIndexOf(" ") + 1) < (t = r.lastIndexOf("/")) && (s = r.substring(e, t), a = r.substring(t + 1), s.toLowerCase() == s.toUpperCase() && (s = navigator.appName)), -1 !== (n = a.indexOf(";")) && (a = a.substring(0, n)), -1 !== (n = a.indexOf(" ")) && (a = a.substring(0, n)), o = parseInt("" + a, 10), isNaN(o) && (a = "" + parseFloat(navigator.appVersion), o = parseInt(navigator.appVersion, 10)), {
            name: s,
            version: o,
            ios: /(iPad|iPhone|iPod)/g.test(navigator.platform)
        }
    }

    function s(e, t) {
        var n = e.media;
        if ("video" == e.type) switch (t) {
                case "video/webm":
                    return !(!n.canPlayType || !n.canPlayType('video/webm; codecs="vp8, vorbis"').replace(/no/, ""));
                case "video/mp4":
                    return !(!n.canPlayType || !n.canPlayType('video/mp4; codecs="avc1.42E01E, mp4a.40.2"').replace(/no/, ""));
                case "video/ogg":
                    return !(!n.canPlayType || !n.canPlayType('video/ogg; codecs="theora"').replace(/no/, ""))
            } else if ("audio" == e.type) switch (t) {
                case "audio/mpeg":
                    return !(!n.canPlayType || !n.canPlayType("audio/mpeg;").replace(/no/, ""));
                case "audio/ogg":
                    return !(!n.canPlayType || !n.canPlayType('audio/ogg; codecs="vorbis"').replace(/no/, ""));
                case "audio/wav":
                    return !(!n.canPlayType || !n.canPlayType('audio/wav; codecs="1"').replace(/no/, ""))
            }
            return !1
    }

    function a(e, t) {
        return Array.prototype.indexOf && -1 != e.indexOf(t)
    }

    function o(e, t, n) {
        return e.replace(new RegExp(t.replace(/([.*+?^=!:${}()|\[\]\/\\])/g, "\\$1"), "g"), n)
    }

    function i(e, t) {
        e.length || (e = [e]);
        for (var n = e.length - 1; n >= 0; n--) {
            var r = n > 0 ? t.cloneNode(!0) : t,
                s = e[n],
                a = s.parentNode,
                o = s.nextSibling;
            r.appendChild(s), o ? a.insertBefore(r, o) : a.appendChild(r)
        }
    }

    function l(e) {
        for (var t = e.parentNode; e.firstChild;) t.insertBefore(e.firstChild, e);
        t.removeChild(e)
    }

    function c(e) {
        e.parentNode.removeChild(e)
    }

    function u(e, t) {
        e.insertBefore(t, e.firstChild)
    }

    function p(e, t) {
        for (var n in t) e.setAttribute(n, t[n])
    }

    function d(e, t, n) {
        if (e)
            if (e.classList) e.classList[n ? "add" : "remove"](t);
            else {
                var r = (" " + e.className + " ").replace(/\s+/g, " ").replace(" " + t + " ", "");
                e.className = r + (n ? " " + t : "")
            }
    }

    function f(e, t, n, r) {
        var s = t.split(" ");
        if (e instanceof NodeList)
            for (var a = 0; a < e.length; a++) e[a] instanceof Node && f(e[a], arguments[1], arguments[2], arguments[3]);
        else
            for (var o = 0; o < s.length; o++) e[r ? "addEventListener" : "removeEventListener"](s[o], n, !1)
    }

    function m(e, t, n) {
        e && f(e, t, n, !0)
    }

    function y(e, t, n) {
        e && f(e, t, n, !1)
    }

    function v(e, t) {
        var n = document.createEvent("MouseEvents");
        n.initEvent(t, !0, !0), e.dispatchEvent(n)
    }

    function b(e) {
        return e.keyCode && 13 != e.keyCode ? !0 : (e.target.checked = !e.target.checked, v(e.target, "change"), void 0)
    }

    function g(e, t) {
        return 0 === e || 0 === t || isNaN(e) || isNaN(t) ? 0 : (e / t * 100).toFixed(2)
    }

    function h(e, t) {
        for (var n in t) t[n] && t[n].constructor && t[n].constructor === Object ? (e[n] = e[n] || {}, h(e[n], t[n])) : e[n] = t[n];
        return e
    }

    function k() {
        var e = {
                supportsFullScreen: !1,
                isFullScreen: function() {
                    return !1
                },
                requestFullScreen: function() {},
                cancelFullScreen: function() {},
                fullScreenEventName: "",
                element: null,
                prefix: ""
            },
            t = "webkit moz o ms khtml".split(" ");
        if ("undefined" != typeof document.cancelFullScreen) e.supportsFullScreen = !0;
        else
            for (var n = 0, r = t.length; r > n; n++) {
                if (e.prefix = t[n], "undefined" != typeof document[e.prefix + "CancelFullScreen"]) {
                    e.supportsFullScreen = !0;
                    break
                }
                if ("undefined" != typeof document.msExitFullscreen && document.msFullscreenEnabled) {
                    e.prefix = "ms", e.supportsFullScreen = !0;
                    break
                }
            }
        return "webkit" === e.prefix && navigator.userAgent.match(/Version\/[\d\.]+.*Safari/) && (e.supportsFullScreen = !1), e.supportsFullScreen && (e.fullScreenEventName = "ms" == e.prefix ? "MSFullscreenChange" : e.prefix + "fullscreenchange", e.isFullScreen = function(e) {
            switch ("undefined" == typeof e && (e = document), this.prefix) {
                case "":
                    return document.fullscreenElement == e;
                case "moz":
                    return document.mozFullScreenElement == e;
                default:
                    return document[this.prefix + "FullscreenElement"] == e
            }
        }, e.requestFullScreen = function(e) {
            return "" === this.prefix ? e.requestFullScreen() : e[this.prefix + ("ms" == this.prefix ? "RequestFullscreen" : "RequestFullScreen")]("webkit" === this.prefix ? e.ALLOW_KEYBOARD_INPUT : null)
        }, e.cancelFullScreen = function() {
            return "" === this.prefix ? document.cancelFullScreen() : document[this.prefix + ("ms" == this.prefix ? "ExitFullscreen" : "CancelFullScreen")]()
        }, e.element = function() {
            return "" === this.prefix ? document.fullscreenElement : document[this.prefix + "FullscreenElement"]
        }), e
    }

    function x() {
        var e = {
            supported: function() {
                try {
                    return "localStorage" in window && null !== window.localStorage
                } catch (e) {
                    return !1
                }
            }()
        };
        return e
    }

    function w(a) {
        function f(e) {
            if (!ot.usingTextTracks && "video" === ot.type && ot.supported.full) {
                for (ot.subcount = 0, e = "number" == typeof e ? e : ot.media.currentTime; S(ot.captions[ot.subcount][0]) < e.toFixed(1);)
                    if (ot.subcount++, ot.subcount > ot.captions.length - 1) {
                        ot.subcount = ot.captions.length - 1;
                        break
                    }
                ot.media.currentTime.toFixed(1) >= w(ot.captions[ot.subcount][0]) && ot.media.currentTime.toFixed(1) <= S(ot.captions[ot.subcount][0]) ? (ot.currentCaption = ot.captions[ot.subcount][1], ot.captionsContainer.innerHTML = ot.currentCaption) : ot.captionsContainer.innerHTML = ""
            }
        }

        function h() {
            ot.buttons.captions && (d(ot.container, F.classes.captions.enabled, !0), F.captions.defaultActive && (d(ot.container, F.classes.captions.active, !0), ot.buttons.captions.checked = !0))
        }

        function w(e) {
            var t = [];
            return t = e.split(" --> "), C(t[0])
        }

        function S(e) {
            var t = [];
            return t = e.split(" --> "), C(t[1])
        }

        function C(e) {
            if (null === e || void 0 === e) return 0;
            var t, n = [],
                r = [];
            return n = e.split(","), r = n[0].split(":"), t = Math.floor(60 * r[0] * 60) + Math.floor(60 * r[1]) + Math.floor(r[2])
        }

        function E(e) {
            return ot.container.querySelectorAll(e)
        }

        function A(e) {
            return E(e)[0]
        }

        function N() {
            try {
                return window.self !== window.top
            } catch (e) {
                return !0
            }
        }

        function P() {
            var e = F.html;
            if (n("Injecting custom controls."), e || (e = t()), e = o(e, "{seektime}", F.seekTime), e = o(e, "{id}", Math.floor(1e4 * Math.random())), ot.container.insertAdjacentHTML("beforeend", e), F.tooltips)
                for (var r = E(F.selectors.labels), s = r.length - 1; s >= 0; s--) {
                    var a = r[s];
                    d(a, F.classes.hidden, !1), d(a, F.classes.tooltip, !0)
                }
        }

        function I() {
            try {
                return ot.controls = A(F.selectors.controls), ot.buttons = {}, ot.buttons.seek = A(F.selectors.buttons.seek), ot.buttons.play = A(F.selectors.buttons.play), ot.buttons.pause = A(F.selectors.buttons.pause), ot.buttons.restart = A(F.selectors.buttons.restart), ot.buttons.rewind = A(F.selectors.buttons.rewind), ot.buttons.forward = A(F.selectors.buttons.forward), ot.buttons.fullscreen = A(F.selectors.buttons.fullscreen), ot.buttons.mute = A(F.selectors.buttons.mute), ot.buttons.captions = A(F.selectors.buttons.captions), ot.checkboxes = E("[type='checkbox']"), ot.progress = {}, ot.progress.container = A(F.selectors.progress.container), ot.progress.buffer = {}, ot.progress.buffer.bar = A(F.selectors.progress.buffer), ot.progress.buffer.text = ot.progress.buffer.bar && ot.progress.buffer.bar.getElementsByTagName("span")[0], ot.progress.played = {}, ot.progress.played.bar = A(F.selectors.progress.played), ot.progress.played.text = ot.progress.played.bar && ot.progress.played.bar.getElementsByTagName("span")[0], ot.volume = A(F.selectors.buttons.volume), ot.duration = A(F.selectors.duration), ot.currentTime = A(F.selectors.currentTime), ot.seekTime = E(F.selectors.seekTime), !0
            } catch (e) {
                return n("It looks like there's a problem with your controls html. Bailing.", !0), ot.media.setAttribute("controls", ""), !1
            }
        }

        function M() {
            if (ot.buttons.play) {
                var e = ot.buttons.play.innerText || "Play";
                "undefined" != typeof F.title && F.title.length && (e += ", " + F.title), ot.buttons.play.setAttribute("aria-label", e)
            }
        }

        function L() {
            if (!ot.media) return n("No audio or video element found!", !0), !1;
            if (ot.supported.full && (ot.media.removeAttribute("controls"), d(ot.container, F.classes[ot.type], !0), d(ot.container, F.classes.stopped, null === ot.media.getAttribute("autoplay")), ot.browser.ios && d(ot.container, "ios", !0), "video" === ot.type)) {
                var e = document.createElement("div");
                e.setAttribute("class", F.classes.videoWrapper), i(ot.media, e), ot.videoContainer = e
            }
            null !== ot.media.getAttribute("autoplay") && H()
        }

        function O() {
            if ("video" === ot.type) {
                ot.videoContainer.insertAdjacentHTML("afterbegin", "<div class='" + F.selectors.captions.replace(".", "") + "'></div>"), ot.captionsContainer = A(F.selectors.captions), ot.usingTextTracks = !1, ot.media.textTracks && (ot.usingTextTracks = !0);
                for (var e, t = "", r = ot.media.childNodes, s = 0; s < r.length; s++) "track" === r[s].nodeName.toLowerCase() && (e = r[s].getAttribute("kind"), "captions" === e && (t = r[s].getAttribute("src")));
                if (ot.captionExists = !0, "" === t ? (ot.captionExists = !1, n("No caption track found.")) : n("Caption track found; URI: " + t), ot.captionExists) {
                    for (var a = ot.media.textTracks, o = 0; o < a.length; o++) a[o].mode = "hidden";
                    if (h(ot), ("IE" === ot.browser.name && 10 === ot.browser.version || "IE" === ot.browser.name && 11 === ot.browser.version || "Firefox" === ot.browser.name && ot.browser.version >= 31 || "Safari" === ot.browser.name && ot.browser.version >= 7) && (n("Detected IE 10/11 or Firefox 31+ or Safari 7+."), ot.usingTextTracks = !1), ot.usingTextTracks) {
                        n("TextTracks supported.");
                        for (var i = 0; i < a.length; i++) {
                            var l = a[i];
                            "captions" === l.kind && m(l, "cuechange", function() {
                                ot.captionsContainer.innerHTML = "", this.activeCues[0] && this.activeCues[0].hasOwnProperty("text") && ot.captionsContainer.appendChild(this.activeCues[0].getCueAsHTML())
                            })
                        }
                    } else if (n("TextTracks not supported so rendering captions manually."), ot.currentCaption = "", ot.captions = [], "" !== t) {
                        var c = new XMLHttpRequest;
                        c.onreadystatechange = function() {
                            if (4 === c.readyState)
                                if (200 === c.status) {
                                    var e, t = [],
                                        r = c.responseText;
                                    t = r.split("\n\n");
                                    for (var s = 0; s < t.length; s++) e = t[s], ot.captions[s] = [], ot.captions[s] = e.split("\n");
                                    ot.captions.shift(), n("Successfully loaded the caption file via AJAX.")
                                } else n("There was a problem loading the caption file via AJAX.", !0)
                        }, c.open("get", t, !0), c.send()
                    }
                    if ("Safari" === ot.browser.name && ot.browser.version >= 7) {
                        n("Safari 7+ detected; removing track from DOM."), a = ot.media.getElementsByTagName("track");
                        for (var u = 0; u < a.length; u++) ot.media.removeChild(a[u])
                    }
                } else d(ot.container, F.classes.captions.enabled)
            }
        }

        function q() {
            if ("video" === ot.type && F.fullscreen.enabled) {
                var e = T.supportsFullScreen;
                e || F.fullscreen.fallback && !N() ? (n((e ? "Native" : "Fallback") + " fullscreen enabled."), d(ot.container, F.classes.fullscreen.enabled, !0)) : n("Fullscreen not supported and fallback disabled."), F.fullscreen.hideControls && d(ot.container, F.classes.fullscreen.hideControls, !0)
            }
        }

        function H() {
            ot.media.play()
        }

        function V() {
            ot.media.pause()
        }

        function B(e) {
            "number" != typeof e && (e = F.seekTime), j(ot.media.currentTime - e)
        }

        function R(e) {
            "number" != typeof e && (e = F.seekTime), j(ot.media.currentTime + e)
        }

        function j(e) {
            var t = 0;
            "number" == typeof e ? t = e : "object" != typeof e || "input" !== e.type && "change" !== e.type || (t = e.target.value / e.target.max * ot.media.duration), 0 > t ? t = 0 : t > ot.media.duration && (t = ot.media.duration);
            try {
                ot.media.currentTime = t.toFixed(1)
            } catch (r) {}
            n("Seeking to " + ot.media.currentTime + " seconds"), f(t)
        }

        function D() {
            d(ot.container, F.classes.playing, !ot.media.paused), d(ot.container, F.classes.stopped, ot.media.paused)
        }

        function W(e) {
            var t = T.supportsFullScreen;
            e && e.type === T.fullScreenEventName ? ot.isFullscreen = T.isFullScreen(ot.container) : t ? (T.isFullScreen(ot.container) ? T.cancelFullScreen() : T.requestFullScreen(ot.container), ot.isFullscreen = T.isFullScreen(ot.container)) : (ot.isFullscreen = !ot.isFullscreen, ot.isFullscreen ? (m(document, "keyup", z), document.body.style.overflow = "hidden") : (y(document, "keyup", z), document.body.style.overflow = "")), d(ot.container, F.classes.fullscreen.active, ot.isFullscreen), ot.isFullscreen && d(ot.controls, F.classes.hover, !1)
        }

        function z(e) {
            27 === (e.which || e.charCode || e.keyCode) && ot.isFullscreen && W()
        }

        function U(e) {
            "undefined" == typeof e && (e = F.storage.enabled && x().supported ? window.localStorage[F.storage.key] || F.volume : F.volume), n(e), e > 10 && (e = 10), 0 > e && (e = 0), ot.media.volume = parseFloat(e / 10), ot.media.muted && e > 0 && X()
        }

        function X(e) {
            "undefined" == typeof e && (e = !ot.media.muted), ot.media.muted = e
        }

        function _() {
            var e = ot.media.muted ? 0 : 10 * ot.media.volume;
            ot.supported.full && ot.volume && (ot.volume.value = e), F.storage.enabled && x().supported && window.localStorage.setItem(F.storage.key, e), d(ot.container, F.classes.muted, 0 === e), ot.supported.full && ot.buttons.mute && (ot.buttons.mute.checked = 0 === e)
        }

        function J(e) {
            ot.supported.full && ot.buttons.captions && ("undefined" == typeof e && (e = -1 === ot.container.className.indexOf(F.classes.captions.active), ot.buttons.captions.checked = e), d(ot.container, F.classes.captions.active, e))
        }

        function $(e) {
            var t = "waiting" === e.type;
            clearTimeout(ot.loadingTimer), ot.loadingTimer = setTimeout(function() {
                d(ot.container, F.classes.loading, t)
            }, t ? 250 : 0)
        }

        function K(e) {
            var t = ot.progress.played.bar,
                n = ot.progress.played.text,
                r = 0;
            if (e) switch (e.type) {
                case "timeupdate":
                case "seeking":
                    r = g(ot.media.currentTime, ot.media.duration), "timeupdate" == e.type && ot.buttons.seek && (ot.buttons.seek.value = r);
                    break;
                case "change":
                case "input":
                    r = e.target.value;
                    break;
                case "playing":
                case "progress":
                    t = ot.progress.buffer.bar, n = ot.progress.buffer.text, r = function() {
                        var e = ot.media.buffered;
                        return e.length ? g(e.end(0), ot.media.duration) : 0
                    }()
            }
            t && (t.value = r), n && (n.innerHTML = r)
        }

        function Y(e, t) {
            if (t) {
                ot.secs = parseInt(e % 60), ot.mins = parseInt(e / 60 % 60), ot.hours = parseInt(e / 60 / 60 % 60);
                var n = parseInt(ot.media.duration / 60 / 60 % 60) > 0;
                ot.secs = ("0" + ot.secs).slice(-2), ot.mins = ("0" + ot.mins).slice(-2), t.innerHTML = (n ? ot.hours + ":" : "") + ot.mins + ":" + ot.secs
            }
        }

        function G() {
            var e = ot.media.duration || 0;
            !ot.duration && F.displayDuration && ot.media.paused && Y(e, ot.currentTime), ot.duration && Y(e, ot.duration)
        }

        function Q(e) {
            Y(ot.media.currentTime, ot.currentTime), K(e)
        }

        function Z() {
            for (var e = ot.media.querySelectorAll("source"), t = e.length - 1; t >= 0; t--) c(e[t]);
            ot.media.removeAttribute("src")
        }

        function et(e) {
            if (e.src) {
                var t = document.createElement("source");
                p(t, e), u(ot.media, t)
            }
        }

        function tt(e) {
            if (V(), j(), Z(), "string" == typeof e) ot.media.setAttribute("src", e);
            else if (e.constructor === Array)
                for (var t in e) et(e[t]);
            ot.supported.full && (Q(), D()), ot.media.load(), null !== ot.media.getAttribute("autoplay") && H()
        }

        function nt(e) {
            "video" === ot.type && ot.media.setAttribute("poster", e)
        }

        function rt() {
            var e = "IE" == ot.browser.name ? "change" : "input";
            m(ot.buttons.play, "click", function() {
                H(), setTimeout(function() {
                    ot.buttons.pause.focus()
                }, 100)
            }), m(ot.buttons.pause, "click", function() {
                V(), setTimeout(function() {
                    ot.buttons.play.focus()
                }, 100)
            }), m(ot.buttons.restart, "click", j), m(ot.buttons.rewind, "click", B), m(ot.buttons.forward, "click", R), m(ot.buttons.seek, e, j), m(ot.volume, e, function() {
                U(this.value)
            }), m(ot.buttons.mute, "change", function() {
                X(this.checked)
            }), m(ot.buttons.fullscreen, "click", W), T.supportsFullScreen && m(document, T.fullScreenEventName, W), m(ot.media, "timeupdate seeking", Q), m(ot.media, "timeupdate", f), m(ot.media, "loadedmetadata", G), m(ot.buttons.captions, "change", function() {
                J(this.checked)
            }), m(ot.media, "ended", function() {
                "video" === ot.type && (ot.captionsContainer.innerHTML = ""), D()
            }), m(ot.media, "progress", K), m(ot.media, "playing", K), m(ot.media, "volumechange", _), m(ot.media, "play pause", D), m(ot.media, "waiting canplay seeked", $), m(ot.checkboxes, "keyup", b), "video" === ot.type && F.click && m(ot.videoContainer, "click", function() {
                ot.media.paused ? v(ot.buttons.play, "click") : ot.media.ended ? (j(), v(ot.buttons.play, "click")) : v(ot.buttons.pause, "click")
            }), F.fullscreen.hideControls && m(ot.controls, "mouseenter mouseleave", function(e) {
                d(ot.controls, F.classes.hover, "mouseenter" === e.type)
            })
        }

        function st() {
            if (!ot.init) return null;
            ot.container.setAttribute("class", F.selectors.container.replace(".", "")), c(A(F.selectors.controls)), "video" === ot.type && (c(A(F.selectors.captions)), l(ot.videoContainer)), ot.media.setAttribute("controls", "");
            var e = ot.media.cloneNode(!0);
            ot.media.parentNode.replaceChild(e, ot.media), ot.init = !1
        }

        function at() {
            if (ot.init) return null;
            if (T = k(), ot.browser = r(), ot.media = ot.container.querySelectorAll("audio, video")[0], ot.type = ot.media.tagName.toLowerCase(), ot.supported = e.supported(ot.type), !ot.supported.basic) return !1;
            if (n(ot.browser.name + " " + ot.browser.version), L(), ot.supported.full) {
                if (P(), !I()) return !1;
                F.displayDuration && G(), M(), O(), U(), _(), q(), rt()
            }
            ot.init = !0
        }
        var ot = this;
        return ot.container = a, at(), ot.init ? {
            media: ot.media,
            play: H,
            pause: V,
            restart: j,
            rewind: B,
            forward: R,
            seek: j,
            source: tt,
            poster: nt,
            setVolume: U,
            toggleMute: X,
            toggleCaptions: J,
            toggleFullscreen: W,
            isFullscreen: function() {
                return ot.isFullscreen || !1
            },
            support: function(e) {
                return s(ot, e)
            },
            destroy: st,
            restore: at
        } : {}
    }
    var T, F, S = {
        enabled: !0,
        debug: !1,
        seekTime: 10,
        volume: 5,
        click: !0,
        tooltips: !1,
        displayDuration: !0,
        selectors: {
            container: ".player",
            controls: ".player-controls",
            labels: "[data-player] .sr-only, label .sr-only",
            buttons: {
                seek: "[data-player='seek']",
                play: "[data-player='play']",
                pause: "[data-player='pause']",
                restart: "[data-player='restart']",
                rewind: "[data-player='rewind']",
                forward: "[data-player='fast-forward']",
                mute: "[data-player='mute']",
                volume: "[data-player='volume']",
                captions: "[data-player='captions']",
                fullscreen: "[data-player='fullscreen']"
            },
            progress: {
                container: ".player-progress",
                buffer: ".player-progress-buffer",
                played: ".player-progress-played"
            },
            captions: ".player-captions",
            currentTime: ".player-current-time",
            duration: ".player-duration"
        },
        classes: {
            video: "player-video",
            videoWrapper: "player-video-wrapper",
            audio: "player-audio",
            stopped: "stopped",
            playing: "playing",
            muted: "muted",
            loading: "loading",
            tooltip: "player-tooltip",
            hidden: "sr-only",
            hover: "hover",
            captions: {
                enabled: "captions-enabled",
                active: "captions-active"
            },
            fullscreen: {
                enabled: "fullscreen-enabled",
                active: "fullscreen-active",
                hideControls: "fullscreen-hide-controls"
            }
        },
        captions: {
            defaultActive: !1
        },
        fullscreen: {
            enabled: !0,
            fallback: !0,
            hideControls: !0
        },
        storage: {
            enabled: !0,
            key: "plyr_volume"
        },
        controls: ["restart", "rewind", "play", "fast-forward", "current-time", "duration", "mute", "volume", "captions", "fullscreen"],
        onSetup: function() {}
    };
    e.supported = function(e) {
        var t, n, s = r(),
            a = "IE" === s.name && s.version <= 9,
            o = /iPhone|iPod/i.test(navigator.userAgent),
            i = !!document.createElement("audio").canPlayType,
            l = !!document.createElement("video").canPlayType;
        switch (e) {
            case "video":
                t = l, n = t && !a && !o;
                break;
            case "audio":
                t = i, n = t && !a;
                break;
            default:
                t = i && l, n = t && !a
        }
        return {
            basic: t,
            full: n
        }
    }, e.setup = function(t) {
        if (F = h(S, t), !F.enabled || !e.supported().basic) return !1;
        for (var n = document.querySelectorAll(F.selectors.container), r = [], s = n.length - 1; s >= 0; s--) {
            var a = n[s];
            if ("undefined" == typeof a.plyr) {
                var o = new w(a);
                a.plyr = Object.keys(o).length ? o : !1, F.onSetup.apply(a.plyr)
            }
            r.push(a.plyr)
        }
        return r
    }
}(this.plyr = this.plyr || {});