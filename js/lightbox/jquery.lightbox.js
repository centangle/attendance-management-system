/*!
 * jQuery Lightbox Evolution - for jQuery 1.3+
 * http://codecanyon.net/item/jquery-lightbox-evolution/115655?ref=aeroalquimia
 *
 * Copyright 2010, Eduardo Daniel Sada
 * You need to buy a license if you want use this script.
 * http://codecanyon.net/wiki/buying/howto-buying/licensing/
 *
 * Version: 1.2 (Ago 02 2010)
 *
 * Includes jQuery Easing v1.1.2
 * http://gsgd.co.uk/sandbox/jquery.easIng.php
 * Copyright (c) 2007 George Smith
 * Released under the MIT License.
 */

(function($) {
  
  var ie6 = ($.browser.msie && parseInt($.browser.version, 10) < 7 && parseInt($.browser.version, 10) > 4);
  
  if ($.proxy === undefined) {
    $.extend({
      proxy: function( fn, thisObject ) {
        if ( fn )
        {
          proxy = function() { return fn.apply( thisObject || this, arguments ); };
        };
        return proxy;
      }
    });
  };
    
  if ($.isEmptyObject === undefined) {
    $.extend({
      isEmptyObject: function( obj ) {
        for ( var name in obj ) {
          return false;
        }
        return true;
      }
    });
  };


  $.extend( $.easing, {
    easeOutBack: function (x, t, b, c, d, s) {
      if (s == undefined) s = 1.70158;
      return c*((t=t/d-1)*t*((s+1)*t + s) + 1) + b;
    }
  });

  $.extend({
    LightBoxObject: {
      defaults    : {
                      name            : 'jquery-lightbox',
                      zIndex          : 7000,
                      width           : 470,
                      height          : 280,
                      background      : '#FFFFFF',
                      modal           : false,
                      overlay         : {
                                        'opacity'           : 0.6
                                        },
                      showDuration    : 400,
                      closeDuration   : 200,
                      moveDuration    : 1000,
                      resizeDuration  : 1000,
                      shake           : {
                                        'distance'   : 10,
                                        'duration'   : 100,
                                        'transition' : 'easeOutBack',
                                        'loops'      : 2
                                      },
                      emergefrom      : 'top'
                    },
      options     : {},
      animations  : {},
      gallery     : {},
      image       : {},
      esqueleto   : {
                      lightbox    : [],
                      buttons     : {
                                      close     : [],
                                      prev      : [],
                                      max       : [],
                                      next      : []
                                    },
                      background  : [],
                      html        : []
                    },
      visible     : false,
      maximized   : false,
      mode        : 'image',
      videoregs   : {
        swf: {
          reg: /[^\.]\.(swf)\s*$/i
        },
        youtube: {
          reg: /youtube\.com\/watch/i,
          split: '=',
          index: 1,
          url: "http://www.youtube.com/v/%id%&amp;autoplay=1&amp;fs=1"
        },
        metacafe: {
          reg: /metacafe\.com\/watch/i,
          split: '/',
          index: 4,
          url: "http://www.metacafe.com/fplayer/%id%/.swf?playerVars=autoPlay=yes"
        },
        dailymotion: {
          reg: /dailymotion\.com\/video/i,
          split: '/',
          index: 4,
          url: "http://www.dailymotion.com/swf/video/%id%?additionalInfos=0&amp;autoStart=1"
        },
        google: {
          reg: /google\.com\/videoplay/i,
          split: '=',
          index: 1,
          url: "http://video.google.com/googleplayer.swf?autoplay=1&amp;hl=en&amp;docId=%id%"
        },
        vimeo: {
          reg: /vimeo\.com/i,
          split: '/',
          index: 3,
          url: "http://vimeo.com/moogaloop.swf?clip_id=%id%&amp;server=vimeo.com&amp;autoplay=1&amp;show_title=1&amp;show_byline=1&amp;show_portrait=0&amp;color=&amp;fullscreen=1"
        },
        megavideo: {
          reg: /megavideo.com/i,
          split: '=',
          index: 1,
          url: "http://www.megavideo.com/v/%id%"
        },
        gametrailers: {
          reg: /gametrailers.com/i,
          split: '/',
          index: 5,
          url: "http://www.gametrailers.com/remote_wrap.php?mid=%id%"
        },
        collegehumor: {
          reg: /collegehumor.com/i,
          split: 'video:',
          index: 1,
          url: "http://www.collegehumor.com/moogaloop/moogaloop.swf?autoplay=true&amp;fullscreen=1&amp;clip_id=%id%"
        },
        ustream: {
          reg: /ustream.tv/i,
          split: '/',
          index: 4,
          url: "http://www.ustream.tv/flash/video/%id%?loc=%2F&amp;autoplay=true&amp;vid=%id%&amp;disabledComment=true&amp;beginPercent=0.5331&amp;endPercent=0.6292&amp;locale=en_US"
        },
        twitvid: {
          reg: /twitvid.com/i,
          split: '/',
          index: 3,
          url: "http://www.twitvid.com/player/%id%"
        }
      },
      
      mapsreg: {
        bing: {
          reg: /bing.com\/maps/i,
          split: '?',
          index: 1,
          url: "http://www.bing.com/maps/embed/?emid=3ede2bc8-227d-8fec-d84a-00b6ff19b1cb&amp;w=%width%&amp;h=%height%&amp;%id%"
        },
        streetview: {
          reg: /maps.google.com(.*)layer=c/i,
          split: '?',
          index: 1,
          url: "http://maps.google.com/?output=svembed&amp;%id%"
        },
        google: {
          reg: /maps.google.com/i,
          split: '?',
          index: 1,
          url: "http://maps.google.com/?output=embed&amp;%id%"
        }
      },
      
      overlay : {
        create: function(options) {
          this.options = options;
          this.element = $('<div id="'+new Date().getTime()+'" class="'+this.options.name+'-overlay"></div>');
          this.element.css($.extend({}, {
            'position'  : 'fixed',
            'top'       : 0,
            'left'      : 0,
            'opacity'   : 0,
            'display'   : 'none',
            'z-index'   : this.options.zIndex
          }, this.options.style));

          this.element.click( $.proxy(function(event) {
            if (this.options.hideOnClick)
            {
              if ($.isFunction(this.options.callback))
              {
                this.options.callback();
              }
              else
              {
                this.hide();
              }
            }
            event.preventDefault();
          }, this));
          
          this.hidden = true;
          this.inject();
          return this;
        },

        inject: function() {
          this.target = $(document.body);
          this.target.append(this.element);

          if(ie6)
          {
            this.element.css({'position': 'absolute'});
            var zIndex = parseInt(this.element.css('zIndex'));
            if (!zIndex)
            {
              zIndex = 1;
              var pos = this.element.css('position');
              if (pos == 'static' || !pos)
              {
                this.element.css({'position': 'relative'});
              }
              this.element.css({'zIndex': zIndex});
            }
            zIndex = (!!(this.options.zIndex || this.options.zIndex === 0) && zIndex > this.options.zIndex) ? this.options.zIndex : zIndex - 1;
            if (zIndex < 0)
            {
              zIndex = 1;
            }
            this.shim = $('<iframe id="IF_'+new Date().getTime()+'" scrolling="no" frameborder=0 src=""></iframe>');
            this.shim.css({
              zIndex    : zIndex,
              position  : 'absolute',
              top       : 0,
              left      : 0,
              border    : 'none',
              width     : 0,
              height    : 0,
              opacity   : 0
            });
            this.shim.insertAfter(this.element);
            $('html, body').css({
              'height'      : '100%',
              'width'       : '100%',
              'margin-left' : 0,
              'margin-right': 0
            });
          }
        },

        resize: function(x, y) {
          this.element.css({ 'height': 0, 'width': 0 });
          if (this.shim) { this.shim.css({ 'height': 0, 'width': 0 }); };

          var win = { x: $(document).width(), y: $(document).height() };
          
          this.element.css({
            'width'   : '100%',
            'height'  : y ? y : win.y
          });
          
          if (this.shim)
          {
            this.shim.css({ 'height': 0, 'width': 0 });
            this.shim.css({
              'position': 'absolute',
              'left'    : 0,
              'top'     : 0,
              'width'   : this.element.width(),
              'height'  : y ? y : win.y
            });
          }
          return this;
        },

        show: function(callback) {
          if (!this.hidden) { return this; };
          if (this.transition) { this.transition.stop(); };
          if (this.shim) { this.shim.css({'display': 'block'}); };
          this.element.css({'display':'block', 'opacity':0});

          this.target.bind('resize', $.proxy(this.resize, this));
          this.resize();
          this.hidden = false;

          this.transition = this.element.fadeTo(this.options.showDuration, this.options.style.opacity, $.proxy(function(){
            if (this.options.style.opacity) { this.element.css(this.options.style) };
            this.element.trigger('show');
            if ($.isFunction(callback)) { callback(); };
          }, this));
          
          return this;
        },

        hide: function(callback) {
          if (this.hidden) { return this; };
          if (this.transition) { this.transition.stop(); };
          if (this.shim) { this.shim.css({'display': 'none'}); };
          this.target.unbind('resize');
          this.hidden = true;

          this.transition = this.element.fadeTo(this.options.closeDuration, 0, $.proxy(function(){
            this.element.trigger('hide');
            if ($.isFunction(callback)) { callback(); };
            this.element.css({ 'height': 0, 'width': 0, 'display': 'none' });
          }, this));

          return this;
        }
      },

      create: function(options) {
        this.options = $.extend(true, this.defaults, options);

        this.overlay.create({
          name          : this.options.name,
          style         : this.options.overlay,
          hideOnClick   : !this.options.modal,
          zIndex        : this.options.zIndex-1,
          callback      : $.proxy(this.close, this),
          showDuration  : this.options.showDuration,
          closeDuration : this.options.closeDuration
        });
        
        this.esqueleto.lightbox       = $('<div class="'+this.options.name+' '+this.options.name+'-mode-image"><div class="'+this.options.name+'-border-top-left"></div><div class="'+this.options.name+'-border-top-middle"></div><div class="'+this.options.name+'-border-top-right"></div><a class="'+this.options.name+'-button-close" href="#close"><span>Close</span></a><div class="'+this.options.name+'-buttons"><div class="'+this.options.name+'-buttons-init"></div><a class="'+this.options.name+'-button-left" href="#"><span>Previous</span></a><a class="'+this.options.name+'-button-max" href="#"><span>Maximize</span></a><div class="'+this.options.name+'-buttons-custom"></div><a class="'+this.options.name+'-button-right" href="#"><span>Next</span></a><div class="'+this.options.name+'-buttons-end"></div></div><div class="'+this.options.name+'-background"></div><div class="'+this.options.name+'-html"></div><div class="'+this.options.name+'-border-bottom-left"></div><div class="'+this.options.name+'-border-bottom-middle"></div><div class="'+this.options.name+'-border-bottom-right"></div></div>');
        this.esqueleto.buttons.div    = $('.'+this.options.name+'-buttons', this.esqueleto.lightbox);
        this.esqueleto.buttons.close  = $('.'+this.options.name+'-button-close', this.esqueleto.lightbox);
        this.esqueleto.buttons.prev   = $('.'+this.options.name+'-button-left', this.esqueleto.lightbox);
        this.esqueleto.buttons.max    = $('.'+this.options.name+'-button-max', this.esqueleto.lightbox);
        this.esqueleto.buttons.next   = $('.'+this.options.name+'-button-right', this.esqueleto.lightbox);
        this.esqueleto.buttons.custom = $('.'+this.options.name+'-buttons-custom', this.esqueleto.lightbox);
        this.esqueleto.background     = $('.'+this.options.name+'-background', this.esqueleto.lightbox);
        this.esqueleto.html           = $('.'+this.options.name+'-html', this.esqueleto.lightbox);

        this.esqueleto.move           = $('<div class="'+this.options.name+'-move"></div>').wrapInner(this.esqueleto.lightbox);
        this.esqueleto.move.css({
          'position'            : 'absolute',
          'z-index'             : this.options.zIndex,
          'top'                 : -999,
          'left'                : -999
        });
        
        $('body').append(this.esqueleto.move);
        
        this.addevents();
        return this.esqueleto.lightbox;
      },
      
      addevents: function() {
        this.esqueleto.buttons.close.bind('click', $.proxy(function(ev) {
          this.close();
          ev.preventDefault();
        }, this));
        
        $(window).bind('resize', $.proxy(function() {
          if (this.visible)
          {
            this.overlay.resize();
            if (!this.maximized) {
              this.movebox();
            }
          }
        }, this));

        $(window).bind('scroll', $.proxy(function() {
          if (this.visible && !this.maximized)
          {
            this.movebox();
          }
        }, this));

        $(document).bind('keydown', $.proxy(function(event) {
          if (this.visible) {
            if (event.keyCode == 27 && this.overlay.options.hideOnClick) { // esc
              this.close();
            }
          }
        }, this));
        
        this.esqueleto.buttons.max.bind('click', $.proxy(function(event) {
          this.maximinimize();
          event.preventDefault();
        }, this));
                
        // heredamos los eventos, desde el overlay:
        this.overlay.element.bind('show', $.proxy(function() { $(this).triggerHandler('show'); }, this));
        this.overlay.element.bind('hide', $.proxy(function() { $(this).triggerHandler('close'); }, this));
      },
      
      create_gallery: function(href) {
        if ($.isArray(href) && href.length > 1) {

          this.gallery.images   = href;
          this.gallery.current  = 0;
          this.gallery.total    = href.length;
          href = href[0];
          
          this.esqueleto.buttons.prev.unbind('click');
          this.esqueleto.buttons.next.unbind('click');

          this.esqueleto.buttons.prev.bind('click', $.proxy(function(event){
            if (this.gallery.current - 1 < 0) {
              this.gallery.current = this.gallery.total - 1;
            } else {
              this.gallery.current = this.gallery.current - 1;
            }

            this.show(this.gallery.images[this.gallery.current]);
            event.preventDefault();
          }, this));

          this.esqueleto.buttons.next.bind('click', $.proxy(function(event){
            if (this.gallery.current + 1 >= this.gallery.total) {
              this.gallery.current = 0;
            } else {
              this.gallery.current = this.gallery.current + 1;
            }
            
            this.show(this.gallery.images[this.gallery.current]);
            event.preventDefault();
          }, this));

        } 
        
        if (this.gallery.total > 1) {
          this.esqueleto.buttons.div.show();
          this.esqueleto.buttons.prev.show();
          this.esqueleto.buttons.next.show();
        } else {
          this.esqueleto.buttons.prev.hide();
          this.esqueleto.buttons.next.hide();
        }
      },
      
      custombuttons: function(buttons, anchor) {
        $.each(buttons, $.proxy(function(i, button) {
          this.esqueleto.buttons.custom.append($('<a href="#" class="'+button['class']+'">'+button.html+'</a>').bind('click', $.proxy(function(e) {
            if ($.isFunction(button.callback)) {
              button.callback(this.image.src, this, anchor);
            }
            e.preventDefault();
          }, this)));
        }, this));
        this.esqueleto.buttons.div.show();
      },
      
      show: function(href, options, callback, anchor) {
        var imgRegExp  = /\.(jpg|jpeg|gif|png|bmp|tiff)(.*)?$/i;
        var type       = '';
        var beforeopen = false;
        
        if (($.isArray(href) && href.length <= 1) || href=='') {
          return false;
        };
        
        this.loading();

        beforeopen = this.visible;
        this.open();
        if (!beforeopen) { this.movebox(); };
                
        this.create_gallery(href, options);

        if ($.isArray(href) && href.length > 1) {
          href = href[0];
        }
        
        var temp = href.split("%LIGHTBOX%");
        
        href = temp[0];
        title = temp[1] || '';

        options = $.extend(true, {
          'width'      : 0,
          'height'     : 0,
          'modal'      : 0,
          'force'      : '',
          'title'      : title,
          'autoresize' : true,
          'iframe'     : false
        }, options || {});
        

        urloptions = this.unserialize(href);
        if (!$.isEmptyObject(urloptions)) {
          options = $.extend({}, options, urloptions);
        }
        
        this.esqueleto.background.unbind('complete');
        
        this.overlay.options.hideOnClick = !options.modal;

        this.maximized = false;
        
        if ($.isArray(options.buttons)){
          this.custombuttons(options.buttons, anchor);
        }
        
        if (options.force != '') {
          type = options.force;
        } else if (options.iframe) {
          type = 'iframe';
        } else if (href.match(imgRegExp)) {
          type = 'image';
        } else {
          $.each(this.videoregs, function(i, e) {
            if (href.split('?')[0].match(e.reg)) {
              type    = 'flash';
              if (e.split) {
                videoid = href.split(e.split)[e.index];
                href = e.url.replace("%id%", videoid);
              }
            }
          });

          $.each(this.mapsreg, function(i, e) {
            if (href.match(e.reg)) {
              type    = 'iframe';
              if (e.split) {
                id = href.split(e.split)[e.index];
                href = e.url.replace("%id%", id).replace("%width%", options.width).replace("%height%", options.height);
              }
            }
          });

          if (type=='') {
            if (href.match(/#/)) {
              obj = href.substr(href.indexOf("#"));
              if ($(obj).length > 0) {
                type = 'inline';
                href = obj;
              } else {
                type = 'ajax';
              }
            } else {
              type = 'ajax';
            }
          }
        }
        
        if (type=='image') {
          this.esqueleto.buttons.max.hide();

          var image = new Image();
          image.onload = $.proxy(function() {
            image.onload = function() {};
            
            if (!this.visible) { return false };
            
            this.image = {
              width   : image.width,
              height  : image.height,
              src     : image.src
            };
            
            this.maximized = !options.autoresize;

            if (options.width) {
              width   = parseInt(options.width);
              height  = parseInt(options.height);
            } else {
              if (options.autoresize) {
                var objsize = this.calculate(image.width, image.height);
                width   = objsize.width;
                height  = objsize.height;
                if (image.width != width || image.height != height) {
                  this.esqueleto.buttons.div.show();
                  this.esqueleto.buttons.max.show();
                }
              } else {
                width   = image.width;
                height  = image.height;
              }
            }
            
            this.resize(width, height);

            this.esqueleto.background.bind('complete', $.proxy(function() {
              if (!this.visible) { return false };

              this.changemode('image');

              this.esqueleto.background.empty();
              this.esqueleto.html.empty();
              
              $(image).hide();

              if (options.title != '') {
                this.esqueleto.background.append($('<div class="'+this.options.name+'-title"></div>').html(options.title));
              }

              this.esqueleto.background.append(image);
              
              $(image).fadeIn(400);
            }, this));
          }, this);
          
          image.onerror = $.proxy(function() {
            this.error("The requested image cannot be loaded. Please try again later.");
          }, this);
          
          image.src = href;
        } else if (type=='flash' || type=='inline' || type=='ajax') {
        
          if (type == 'inline') {
            this.appendhtml($(href).clone(true).show(), options.width > 0 ? options.width : $(href).outerWidth(true), options.height > 0 ? options.height : $(href).outerHeight(true), 'html');
            
          } else if (type == 'ajax') {
            if (options.width) {
              width   = options.width;
              height  = options.height;
            } else {
              this.error("You need to specific the size of the lightbox.");
              return false;
            }

            if (this.animations.ajax) { this.animations.ajax.abort(); };
            this.animations.ajax = $.ajax({
              url     : href,
              type    : "GET",
              cache   : false,
              error   : $.proxy(function() { this.error("The requested content cannot be loaded. Please try again later.") }, this),
              success : $.proxy(function(html) { this.appendhtml(html, width, height, 'html'); }, this)
            });
          
          } else if (type == 'flash') {
            if (options.width) {
              width   = options.width;
              height  = options.height;
            } else {
              width   = 640;
              height  = 360;
            }
            var flash = this.swf2html(href, width, height);

            this.appendhtml($(flash), width, height, 'html');
          }
        } else if (type=='iframe') {
        
          if (options.width) {
            width   = options.width;
            height  = options.height;
          } else {
            this.error("You need to specific the size of the lightbox.");
            return false;
          }
          this.appendhtml($('<iframe id="IF_'+(new Date().getTime())+'" frameborder=0 src="'+href+'"></iframe>').css(options), options.width, options.height, 'html');
        }

        this.callback = $.isFunction(callback) ? callback : function(e) {};
      },
      
      swf2html: function(href, width, height) {
        var str = '<object width="'+width+'" height="'+height+'" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"><param name="movie" value="'+href+'"></param>';
        str += '<param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><param name="wmode" value="transparent"></param>';
        str += '<param name="autostart" value="true"></param><param name="autoplay" value="true"></param><param name="flashvars" value="autostart=1&autoplay=1&fullscreenbutton=1"></param>';
        str += '<param name="width" value="'+width+'"></param><param name="height" value="'+height+'"></param>';
        str += '<embed src="'+href+'" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" autostart="true" autoplay="true" flashvars="autostart=1&autoplay=1&fullscreenbutton=1" wmode="transparent" width="'+width+'" height="'+height+'"></embed></object>';
        return str;
      },
      
      appendhtml: function(obj, width, height, mode) {
        if (typeof mode !== 'undefined') {
          this.changemode(mode);
        }

        this.resize(width + 30, height + 20);

        this.esqueleto.background.bind('complete', $.proxy(function() {
          this.esqueleto.background.removeClass(this.options.name+'-loading');
          this.esqueleto.html.append(obj);
        }, this));
      },
      
      movebox: function(w, h) {
        var size   = { x: $(window).width(),      y: $(window).height() };
        var scroll = { x: $(window).scrollLeft(), y: $(window).scrollTop() };
        var height = h!=null ? h : this.esqueleto.lightbox.outerHeight();
        var width  = w!=null ? w : this.esqueleto.lightbox.outerWidth();
        var y      = 0;
        var x      = 0;

         //vertically center
        x = scroll.x + ((size.x - width) / 2);

        if (this.visible) {
          y = scroll.y + (size.y - height) / 2;
        } else if (this.options.emergefrom == "bottom") {
          y = (scroll.y + size.y + 14);
        } else {// top
          y = (scroll.y - height) - 14;
        }
        
        if (this.visible) {

          if (!this.animations.move) {
            this.morph(this.esqueleto.move, {
              'left' : x
            }, 'move');
          }

          this.morph(this.esqueleto.move, {
            'top'  : y
          }, 'move');

        } else {

          this.esqueleto.move.css({
            'left' : x,
            'top'  : y
          });
        }
      },

      morph: function(el, prop, mode, callback, queue) {

        var optall = $.speed({
          queue     : queue || false,
          duration  : this.options[mode+'Duration'],
          easing    : 'easeOutBack',
          complete  : ($.isFunction(callback) ? $.proxy(callback, this) : null)
        });

        return el[ optall.queue === false ? "each" : "queue" ](function() {
          var opt = $.extend({}, optall), self = this;

          opt.curAnim = $.extend({}, prop);

          $.each( prop, function( name, val ) {
            var e = new $.fx( self, opt, name );

            e.custom( e.cur(true) || 0, val, "px" );
          });

          return true;
        });

      },
      
      resize: function(x, y) {
        if (this.visible) {
          var size   = { x: $(window).width(),      y: $(window).height() };
          var scroll = { x: $(window).scrollLeft(), y: $(window).scrollTop() };
          var left   = (scroll.x + (size.x - (x + 14)) / 2);
          var top    = (scroll.y + (size.y - (y + 14)) / 2);
          
          if ($.browser.msie || ($.browser.mozilla && (parseFloat($.browser.version) < 1.9))) {
            y += 4;
          }
          
          this.animations.move = true;

          this.morph(this.esqueleto.move.stop(), {
            'left': (this.maximized && left < 0) ? 0 : left,
            'top' : (this.maximized && (y + 14) > size.y) ? scroll.y : top
          }, 'move', $.proxy(function() { this.move = false; }, this.animations));

          this.morph(this.esqueleto.html, { 'height': y - 20 }, 'resize');
          this.morph(this.esqueleto.lightbox.stop(), { 'width': (x + 14), 'height': y - 20 }, 'resize', {}, true);
          this.morph(this.esqueleto.background.stop(), { 'width': x, 'height': y }, 'resize', function() { $(this.esqueleto.background).trigger('complete'); });

        } else {

          this.esqueleto.html.css({ 'height': y - 20 });
          this.esqueleto.lightbox.css({ 'width': x + 14, 'height': y - 20 });
          this.esqueleto.background.css({ 'width': x, 'height': y });
        }
      },
      
      close: function(param) {
        this.visible = false;
        this.gallery = {};

        if ($.browser.msie) {
          this.esqueleto.background.empty();
          this.esqueleto.html.empty();
          this.esqueleto.buttons.custom.empty();
          this.esqueleto.move.css({'display': 'none'});
          this.esqueleto.move.stop(true, false);
          this.movebox();
        } else {
          this.esqueleto.move.animate({'opacity': 0, 'top': '-=40'}, {
            queue     : false,
            complete  : ($.proxy(function() {
              this.esqueleto.background.empty();
              this.esqueleto.html.empty();
              this.esqueleto.buttons.custom.empty();
              this.esqueleto.move.stop(true, false);
              this.movebox();
              this.esqueleto.move.css({'display': 'none', 'opacity': 1, 'overflow': 'visible'});
            }, this))
          });
        }
        
        this.overlay.hide($.proxy(function() {
          if ($.isFunction(this.callback))
          {
            this.callback.apply(this, $.makeArray(param));
          }
        }, this));

        this.esqueleto.background.stop(true, false);
        this.esqueleto.background.unbind('complete');
      },
      
      open: function() {
        this.visible = true;
        if ($.browser.msie) {
          this.esqueleto.move.get(0).style.removeAttribute('filter');
          this.esqueleto.buttons.div.css({'position': 'static'}).css({'position': 'absolute'});
        }
        this.esqueleto.move.css({ 'display' : 'block', 'overflow':'visible' }).show();
        this.overlay.show();

      },

      shake: function() {
        var x = this.options.shake.distance;
        var d = this.options.shake.duration;
        var t = this.options.shake.transition;
        var o = this.options.shake.loops;
        var l = this.esqueleto.lightbox.position().left;
        var e = this.esqueleto.lightbox;

        for (i=0; i<o; i++)
        {
         e.animate({left: l+x}, d, t);
         e.animate({left: l-x}, d, t);
        };

        e.animate({left: l+x}, d, t);
        e.animate({left: l},   d, t);
      },
      
      changemode: function(mode) {
        if (mode != this.mode) {
          this.esqueleto.lightbox.removeClass(this.options.name+'-mode-'+this.mode);
          this.mode = mode;
          this.esqueleto.lightbox.addClass(this.options.name+'-mode-'+this.mode);
        }
        this.esqueleto.move.css({'overflow':'visible'});
      },
      
      error: function(msg) {
        alert(msg);
        this.close();
      },
      
      unserialize: function(data) {
        var regex       = /lightbox\[(.*)?\]$/i;
        var serialised  = {};

        if (data.match(/#/)) {
          data = data.slice(0, data.indexOf("#"));
        }
        data = data.slice(data.indexOf('?') + 1).split("&");
        
        $.each(data, function() {
          var properties = this.split("=");
          var key        = properties[0];
          var value      = properties[1];
          
          if (key.match(regex)) {
            if (isFinite(value)) {
              value = parseInt(value)
            } else if (value.toLowerCase() == "true") {
              value = true;
            } else if (value.toLowerCase() == "false") {
              value = false;
            }
            serialised[key.match(regex)[1]] = value;
          }
        });

        return serialised;
      },
      
      calculate: function(x, y) {
        // Resizing large images
        var maxx = $(window).width() - 50;
        var maxy = $(window).height() - 50;

        if (x > maxx)
        {
          y = y * (maxx / x);
          x = maxx;
          if (y > maxy)
          {
            x = x * (maxy / y);
            y = maxy;
          }
        }
        else if (y > maxy)
        {
          x = x * (maxy / y);
          y = maxy;
          if (x > maxx)
          {
            y = y * (maxx / x);
            x = maxx;
          }
        }
        // End Resizing
        return {width: parseInt(x), height: parseInt(y)};
      },

      loading: function() {
        this.changemode('image');
        
        this.esqueleto.background.empty();
        this.esqueleto.html.empty();
        this.esqueleto.background.addClass(this.options.name+'-loading');
        
        this.esqueleto.buttons.div.hide();
        
        this.movebox(this.options.width, this.options.height);
        this.resize(this.options.width, this.options.height);
      },
      
      maximinimize: function() {
        if (this.maximized) {
          this.maximized = false;
          this.esqueleto.buttons.max.removeClass(this.options.name+'-button-min');
          this.esqueleto.buttons.max.addClass(this.options.name+'-button-max');
          var objsize = this.calculate(this.image.width, this.image.height);
          this.loading();
          this.esqueleto.buttons.div.show();
          this.resize(objsize.width, objsize.height);
        } else {
          this.maximized = true;
          this.esqueleto.buttons.max.removeClass(this.options.name+'-button-max');
          this.esqueleto.buttons.max.addClass(this.options.name+'-button-min');
          this.loading();
          this.esqueleto.buttons.div.show();
          this.resize(this.image.width, this.image.height);
        }
      }
      
    }, //end object
   
    lightbox: function(url, options, callback) {
      if (typeof url !== 'undefined') {
        return $.LightBoxObject.show(url, options, callback);
      } else {
        return $.LightBoxObject;
      }
    }
    
  });
  
  $.fn.lightbox = function(options, callback) {
    return $(this).live('click', function(e) {
      e.preventDefault();
      
      $(this).blur();
      
      var sel = [];
      var rel = $(this).attr('rel') || '';
      var til = $(this).attr('title') || '';

      if (!rel || rel == '' || rel === 'nofollow') {
        sel = $(this).attr('href');
        
        copy_options = (til || til != '') ? $.extend({}, options, {'title': til}) : options;

      } else {
        var rels = [];
        var antes = [];
        var desps = [];
        var encon = false;
        
        $("a[rel=" + rel + "], area[rel=" + rel + "]").each($.proxy(function(i, el) {
          if (this == el) {
            antes.unshift(el);
            encon = true;
          } else if (encon == false) {
            desps.push(el);
          } else {
            antes.push(el);
          }
        }, this));

        rels = antes.concat(desps);
        
        $.each(rels, function() {
          title = "%LIGHTBOX%" + $(this).attr('title') || '';
          sel.push($(this).attr('href') + title);
        });
        
        if (sel.length == 1) {
          sel = sel[0];
        }

        copy_options = options;
      }

      $.LightBoxObject.show(sel, copy_options, callback, this);
    });
  };
  
  $(function() {
    $.LightBoxObject.create();
  });
  
})(jQuery);