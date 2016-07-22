/*
	Twenty by HTML5 UP
	html5up.net | @n33co
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
	*/
	require.config({  
		paths: {
			'jquery': 'backbone.marionette/jquery',
			'dropotron': 'jquery.dropotron.min',
			'scrolly': 'jquery.scrolly.min',
			'scrollgress': 'jquery.scrollgress.min',
			'skel': 'skel.min',
			'template': 'template',
			'cycle': '../layout/scripts/jquery.cycle.min',
			'util': 'util',
			'underscore': 'backbone.marionette/underscore',
			'json2': 'backbone.marionette/json2',
			'backbone': 'backbone.marionette/backbone',
			'backbone.babysitter': 'backbone.marionette/backbone.babysitter',
			'backbone.wreqr': 'backbone.marionette/backbone.wreqr',
			'marionette': 'backbone.marionette/backbone.marionette',
		},
		shim: {
			underscore: {
				exports: '_'
			},
			backbone: {
				exports: 'Backbone',
				deps: ['jquery', 'underscore']
			},
			marionette: {
				exports: 'Marionette',
				deps: ['backbone']
			},
			'scrolly': {
				deps: ['jquery'],
				exports: 'scrolly'
			},
			'dropotron': {
				deps: ['jquery'],
				exports: 'dropotron'
			},
			'skel': {
				deps: ['jquery'],
				exports: 'skel'
			}
		},
		deps: ['jquery', 'underscore', 'util', 'cycle', 'scrolly', 'dropotron', 'skel']
	});

	require(['backbone', 'marionette'],function(Backbone, Marionette){
		// console.log(Backbone, Marionette);

              // instancia do App principal
              var CentesimoApp = new Marionette.Application();

              // regioes do App principal
              CentesimoApp.addRegions({
              	mainRegion: "#main-region"
              });

              // LayoutView principal
              // template <script id="app-layoutView-template" type="text/template">
              var AppLayoutView = Marionette.LayoutView.extend({
              	template: "#app-layoutView-template",
              	regions: {
              		header: "#header",
              		menu: "#menu",
                  // content: "#content",
                  // footer: "#footer"
              }
          });

              // App principal on "start"
              CentesimoApp.on("start", function (options) {
              	var layoutView = new AppLayoutView();

              	itemList = new ItemList();
              	itemList.fetch({async: false});
              	// console.log(itemList);
  //                var menu = itemList.models[0].get("menu");

                  //console.log(itemList);
                  
                  var menuView = new MenuView({
                  	collection: itemList
                  });

                  CentesimoApp.mainRegion.show(layoutView);
                  
                  layoutView.menu.show(menuView);

                  // MemedApp History Start
                  Backbone.history.start();

              });
              
              var Item = Backbone.Model.extend({}); //Line 9

              var ItemList = Backbone.Collection.extend({//Line 11
              	model: Item,
              	url: 'http://cielo-portal.centesimolabs.com.br/ws/menu/',
              	parse: function (response) {
                      //console.log(response);
                      return response;
                  }
              });

              var item = Marionette.ItemView.extend({
                // tagName: "li",
                template: "#item-template",
                // className: 'linhaClass'
                'modelEvents': {
                	'change': 'render'
                },onRender: function () {
                    // Get rid of that pesky wrapping-div.
                    // Assumes 1 child element present in template.
                    this.$el = this.$el.children();
                    // Unwrap the element to prevent infinitely 
                    // nesting elements during re-render.
                    this.$el.unwrap();
                    this.setElement(this.$el);
                }
            });

              // CollectionView
              var MenuView = Marionette.CollectionView.extend({
              	template: "#menu-template",
              	childView: item,
                // onRender: function () {
                //     console.log(this.$el);
                // }
            });

              //on ready
              $(function () {
              	skel.breakpoints({
              		wide: '(max-width: 1680px)',
              		normal: '(max-width: 1280px)',
              		narrow: '(max-width: 980px)',
              		narrower: '(max-width: 840px)',
              		mobile: '(max-width: 736px)'
              	});
              	var	$window = $(window),
              	$body = $('body'),
              	$header = $('#header'),
              	$banner = $('#banner');

		// Disable animations/transitions until the page has loaded.
		$body.addClass('is-loading');

		$window.on('load', function() {
			$body.removeClass('is-loading');
		});

		// CSS polyfills (IE<9).
		if (skel.vars.IEVersion < 9)
			$(':last-child').addClass('last-child');

		// Fix: Placeholder polyfill.
		$('form').placeholder();

		// Prioritize "important" elements on narrower.
		skel.on('+narrower -narrower', function() {
			$.prioritize(
				'.important\\28 narrower\\29',
				skel.breakpoint('narrower').active
				);
		});

		// Scrolly links.
		$('.scrolly').scrolly({
			speed: 1000,
			offset: -10
		});

		// Dropdowns.
		$('#nav > ul').dropotron({
			mode: 'fade',
			noOpenerFade: true,
			expandMode: (skel.vars.touch ? 'click' : 'hover')
		});

		// Off-Canvas Navigation.

			// Navigation Button.
			$(
				'<div id="navButton">' +
				'<a href="#navPanel" class="toggle"></a>' +
				'</div>'
				)
			.appendTo($body);

			// Navigation Panel.
			$(
				'<div id="navPanel">' +
				'<nav>' +
				$('#nav').navList() +
				'</nav>' +
				'</div>'
				)
			.appendTo($body)
			.panel({
				delay: 500,
				hideOnClick: true,
				hideOnSwipe: true,
				resetScroll: true,
				resetForms: true,
				side: 'left',
				target: $body,
				visibleClass: 'navPanel-visible'
			});

			// Fix: Remove navPanel transitions on WP<10 (poor/buggy performance).
			if (skel.vars.os == 'wp' && skel.vars.osVersion < 10)
				$('#navButton, #navPanel, #page-wrapper')
			.css('transition', 'none');

		// Header.
		// If the header is using "alt" styling and #banner is present, use scrollwatch
		// to revert it back to normal styling once the user scrolls past the banner.
		// Note: This is disabled on mobile devices.
		if (!skel.vars.mobile
			&&	$header.hasClass('alt')
			&&	$banner.length > 0) {

			$window.on('load', function() {

				$banner.scrollwatch({
					delay:		0,
					range:		1,
					anchor:		'top',
					on:			function() { $header.addClass('alt reveal'); },
					off:		function() { $header.removeClass('alt'); }
				});

			});

	}
                  //MemedApp START
                  CentesimoApp.start();
                  
                  // setTimeout(function(){
                  // 	console.log(itemList);
                  // 	model = itemList.find(function(model) { return model.get('name') === 'Home'; });
                  // 	model.set("name", "Logado")
                  // }, 3000);

                  function ajaxBus(url){
                  	var ajaxResponse;
                  	Backbone.ajax(
                  	{
                  		url: url,
                  		data: "",
                  		success: function(val){
                  			ajaxResponse = val;
                  			//console.log(ajaxResponse);
                  		}
                  	}
                  	);
                    // console.log(ajax);
                }

                //ajaxBus('http://localhost/portal/ws/content_home/');

                $( "#menu li:first-child" ).addClass( "last" );

                $('#featured_slide').after('<div id="fsn"><ul id="fs_pagination">').cycle({
                	timeout: 5000,
                	fx: 'fade',
                	pager: '#fs_pagination',
                	pause: 1,
                	pauseOnPagerHover: 0
                });
            });
          });