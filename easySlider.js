/*
 *  Enhanced Easy Slider
 *
 *  Built off of the Easy Slider - jQuery plugin
 *  written by Alen Grakalic
 *  http://cssglobe.com/post/3783/jquery-plugin-easy-image-or-content-slider
 *
 *  enhancements by Joseph Pecoraro
 *  email: joepeck02@gmail.com
 *  http://blog.bogojoker.com
 *
 *  extra enhancements by RMLG for MLP
 *
 *  The Easy Slider Copyrights:
 *  Copyright (c) 2009 Alen Grakalic (http://cssglobe.com)
 *  Dual licensed under the MIT (MIT-LICENSE.txt)
 *  and GPL (GPL-LICENSE.txt) licenses.
 *
 *  Built for jQuery library
 *  http://jquery.com
 *
 */

/*
 *  Quick Documentation of New Features
 *
 *    * Non-showNextPrevIconserated Pagination - set the showNextPrevIconseratePagination
 *      option to false in the easySlide options and be sure to provide
 *      id's in the prevId and nextId options.  Those provided ids will
 *      unobtrusively get the easySlide actions applied to them.
 *
 *    * Looping - just set the loop option to true in the easySlide
 *      options and you will be able to navigate forward/backward around
 *      the ends smoothly.
 *
 *    * Autoplay - just set the autoplayDuration to a non-zero value
 *      in the easySlide options and the content will slide on its own.
 *      The value you provide will only be the value between animations,
 *      so you don't have to compensate for the speed of transitions,
 *      that is handled automatically.  Autoplaying works fine with
 *      looping.
 *
 *      If you have pagination buttons, when the user clicks a button
 *      the autoplay will suspend for a little while.  The restartDuration
 *      value specifies the amount of time since the last user
 *      interruption to wait before restarting the autoplay.
 *
 *    * Hovering - just set hover to true and pagination will trigger
 *      when hovering instead of clicking.  The slides will continue to
 *      transition as long as you hover over the pagination element.
 *      Hovering works fine with looping.
 *
 *      If you want a pause between slides you can set the hoverPause
 *      value to an integer greater than 0.  That specifies the time
 *      to wait between transitions.
 *
 *    * Linear or Swing easing - jQuery offers two different styles
 *      of animations.  Just set the easing option to 'linear' or
 *      'swing' (default)and it will use that easing style.
 *
 *    * Pauseable - Pause autoplay by hovering over an image.  Likewise
 *      you can extend this to pause when hovering the buttons as well.
 *
 *    * Fade Orientation - Not Vertical or Horizontal Slideing, but Fading!
 *      Just provide orientation: 'fade' for fading to happen.
 *
 *    * Callbacks - You are allowed to provide your own functions for
 *      events triggered by the slider.  You can provide a function
 *      for 'beforeTransition' and 'afterTransition'.  Their signature
 *      is as follows:
 *
 *          function callback( slideNumber, jQuery_li, jQuery_ul )
 *                                 ^            ^         ^
 *                                 |            |         |
 *     int of the slide number -----            |         |
 *     jQuery wrapper for the now showing <li> --         |
 *     jQuery wrapper for the entire <ul> of all slides ---
 *
 *       For example, to get the explicit DOM <li> Node you could do
 *
 *          function after(num, $li, $ul) {
 *            dom_li = $li[0];
 *            console.log(dom_li);
 *          }
 *
 */

(function($) {

  $.fn.easySlider = function(options){

    // default configuration properties
    var defaults = {
      prevId: 'sliderPrevBtn',       // id of the element to apply prev rules to
      nextId: 'sliderNextBtn',       // id of the element to apply next rules to
      showNextPrevIcons: true, 	 // will automatically generate nextPrevIcons
      showPageNumbers: true,        // display page number as links to direct access to page
      pageNumbersContainerId: "slides-nav", // id of element that will contain the page Numbers link
      orientation: 'fade',           // 'vertical', 'fade', or anything else will assume horizontal
      speed: 800,                    // duration of a transition
      autoplayDuration: 5000,        // auto-play if non-zero, this is the time between transitions
      restartDuration: 2500,         // time to restart autoplay after a user interupts and autoplay
      loop: true,                    // loop around the content
      hoverPause: 0,                 // when hovering, the time between transitions
      easing: null,                  // jQuery animation settings 'linear' or 'swing' (default)
      pauseable: true,                // pause autoplay when hovering the image
      pauseButtons: true,           // hovering over the cuttons will pause as well
      beforeTransition: null,        // callback before transitioning
      afterTransition: null          // callback after transitioning
    };

    var options = $.extend(defaults, options);

    return this.each(function() {

      // Setup Measurements and Options
      var obj = $(this),
          totalSlides  = $("li.li-news", obj).length,
          slideWidth   = obj.width(),
          slideHeight  = obj.height() + parseInt(obj.css("padding-top"),10) + parseInt(obj.css("padding-bottom"),10),
          lastSlide    = totalSlides-1,
          current      = 0;

      // States
      var vertical         = (options.orientation == 'vertical'),
          fade             = (options.orientation == 'fade'),
          horizontal       = (!vertical && !fade),
          showNextPrevIcons= options.showNextPrevIcons,
          pauseable        = options.pauseable,
          loop             = options.loop,
          speed            = options.speed,
          easing           = options.easing,
          hoverPause       = options.hoverPause,
          buttonsPause     = options.pauseButtons,
          restartDuration  = options.restartDuration,
          autoplayDuration = Math.max(options.autoplayDuration,25)+speed,
          autoplay         = (options.autoplayDuration > 0),
          beforeTransition = options.beforeTransition,
          afterTransition  = options.afterTransition;
          interval         = null,
          restart          = null,
		  showPageNumbers  = options.showPageNumbers;
		  pageNumbersContainerId  = options.pageNumbersContainerId,
		  isAnimating = false;
		  
	  if (showPageNumbers || showNextPrevIcons) { 
		var pageul = '<ul class="'+pageNumbersContainerId+'">';
		if (showPageNumbers) 
			for (var i = 0; i < totalSlides; i++)
				pageul+='<li id="'+pageNumbersContainerId+'-page-'+i+'"'+((i == 0) ? ' class="on"' : '')+'><a href="#" id="a-'+pageNumbersContainerId+'-page-'+i+'" onclick="">'+(i+1)+'</a></li>';
			
		if (showNextPrevIcons)
		pageul+= '<li id="'+options.nextId+'" style="float:right; margin-right:0"><a href="#">></a></li>'+
				 '<li id="'+options.prevId+'" style="float:right;"><a href="#"><</a></li>';

		pageul+= '</ul>';

		$(pageul).appendTo($(this).parent());
		
		for (var i = 0; i < totalSlides; i++) {
				$('#a-'+pageNumbersContainerId+'-page-'+i).data("page",i);
				$('#a-'+pageNumbersContainerId+'-page-'+i).click(
				function(){
				  if (autoplay) {
					pauseFunc();
					if ( !buttonsPause ) {
					  restartFunc();
					}
				  };
				  
				  if ( !isAnimating ) {
					  isAnimating = true;
					  animateGoToPage( $(this).data("page"), function() {isAnimating = false;});
					}
				return false;
				});
				$('#a-'+pageNumbersContainerId+'-page-'+i).click(function() {this.blur();});
		}
        	
	  }	  

      // Important Elements
      var $ul   = $("ul.ul-news", obj),
          $next = $("#"+options.nextId),
          $prev = $("#"+options.prevId);

      // Loop - Duplicate the First Slide onto the end
      if (loop) {
        $ul.append( $("li.li-news:first", obj).clone() );
        totalSlides += 1;
        lastSlide += 1;
      }

	  $("li.li-news", obj).css('display','');
	  
      // Horizontal - Make them float left and set the width of the ul (for all slides)
      if (horizontal) {
        $("li.li-news", obj).css('float','left');
        $ul.css('width', totalSlides * slideWidth);
      }

      // Fade - Hide all but the first slide so they can fadeIn from nothing
      if (fade) {
        $ul.find("li.li-news:not(:first)").hide();
      }

      // Reusable Closure to pause the autoplay timer
      var pauseFunc = function() {
        clearInterval(interval);
        clearTimeout(restart);
      }

      // Reusable Closure to restart the autoplay timers using the restartDuration
      var restartFunc = function() {
		  pauseFunc(); // added to avoid double movements when starting with mouse over the slide
        restart = setTimeout(function() {
          interval = setInterval(auto, autoplayDuration);
        }, restartDuration);
      };

      // Pauseable (should be autoplay only, but would have no effect otherwise)
      // On Hover: cancel the autoplay timers
      // On Leave: restart the autoplay timers
      if ( pauseable && autoplay ) {
        $(obj).hover(pauseFunc, restartFunc);
      }
      if ( buttonsPause && autoplay ) {
          $next.hover(pauseFunc, restartFunc);
          $prev.hover(pauseFunc, restartFunc);
		  for (var i = 0; i < totalSlides; i++)
			$('#a-'+pageNumbersContainerId+'-page-'+i).hover(pauseFunc, restartFunc);
      }

        $next.click(function(){
          if (autoplay) {
            pauseFunc();
            if ( !buttonsPause ) {
              restartFunc();
            }
          };
		  
		  if ( !isAnimating ) {
              isAnimating = true;
              animate("next", function() {isAnimating = false;});
            }
		return false;
        });
		$next.click(function() {this.blur();});

        $prev.click(function(){
          if (autoplay) {
            pauseFunc();
            if ( !buttonsPause ) {
              restartFunc();
            }
          };
		  if ( !isAnimating ) {
              isAnimating = true;
              animate("prev", function() {isAnimating = false;});
            }
		return false;
        });
		$prev.click(function() {this.blur();});

      //
      // Enclosed Slide Animation
      //
      // This handles all of the sliding/faiding animation
      // @param dir the direction "next" or "prev"
      // @param cb the callback function
      //
      function animate(dir, cb) {
	  
        // Before Transition, Guarantee
		isAnimating = true;
        if ( beforeTransition ) {
          beforeTransition( current, $ul.find('li.li-news:eq('+current+')'), $ul );
        }


        // After Transition, Guarantee
        // Setup the next have
        // NOTE: That current will be the new value when this is called
        // due to it being a closure!
        var newcb = function() {
          if ( cb != null ) {
            ( hoverPause == 0 ) ? cb() : setTimeout(cb, hoverPause);
          }
		  isAnimating = false;
          if ( afterTransition ) {
            afterTransition( current, $ul.find('li.li-news:eq('+current+')'), $ul );
          }
        }


        // cur, nex, and update "current"
        // cur is the old current slide, the slide we are currently on
        // nex is the new current slide, the slide we are transitioning too
        // current is a global value that gets updated right here
        var cur = current;
        if ( loop ) {
          if ( dir == 'next' ) {
            current = (current==lastSlide) ? 1 : current+1;
          } else {
            current = (current==0) ? lastSlide-1 : current-1;
          }
        } else {
          if (dir == "next") {
            current = (current>=lastSlide) ? lastSlide : current+1;
          } else {
            current = (current<=0) ? 0 : current-1;
          }
        }
        var nex = current;

        // Special Case for looping
        // If at the end and going forward, instantaneous jump to the first slide
        // If at the start and going backward, instantaneous jump to the last slide
        // NOTE: The instantaneous jump is an animate() so jQuery handles it in tune
        // with the rest of the animations, and is -1 (not 0) time so its instant.
        if ( loop ) {
          if ( (dir == "next") && (cur == lastSlide) ) {
            (vertical) ?
              $ul.animate({marginTop:0}, -1) :
              $ul.animate({marginLeft:0}, -1);
          } else if ( (dir == "prev") && (cur == 0) && (!fade)) {
            (vertical) ?
              $ul.animate({marginTop:(totalSlides-1)*slideHeight*-1}, -1) :
              $ul.animate({marginLeft:(totalSlides-1)*slideWidth*-1}, -1);
          }
        }
		
        // Dispatch jQuery Animation for the transition
        // Dispatch jQuery Animation for the transition
        // Slide horizontally, vertically, or fade
        if ( horizontal ) {
          $ul.animate( { marginLeft: (nex*slideWidth*-1)  }, speed, easing, newcb );
        } else if ( vertical ) {
          $ul.animate( { marginTop:  (nex*slideHeight*-1) }, speed, easing, newcb );
        } else {
          var curli = 'li.li-news:eq(' + cur + ')';
          var nexli = 'li.li-news:eq(' + nex + ')';
          $ul.find(curli).fadeOut("slow", function() {
            $ul.find(nexli).fadeIn("slow", newcb);
          });
        }

		var currentPage = (!loop) ? cur : ((cur == lastSlide) ? 0 : cur);
		$('#'+pageNumbersContainerId+'-page-'+currentPage).removeClass("on");		
		var nextPage = (!loop) ? nex : ((nex == lastSlide) ? 0 : nex);
		$('#'+pageNumbersContainerId+'-page-'+nextPage).addClass("on");


        // Correctly show the Next/Prev links
        // When looping they always show, so we can ignore that
        // If at the end, hide the next link
        // If at the start, hide the previous link
        // Any other case we can show both links
        if ( !loop ) {
          if ( nex <= 0 ) {
            $prev.fadeOut();
          } else if ( nex >= lastSlide ) {
            $next.fadeOut();
          } else {
            $next.fadeIn();
            $prev.fadeIn();
          }
        }

      };

	  
      function animateGoToPage(nex, cb) {
	  
		if (autoplay) {
            pauseFunc();
		if ( !buttonsPause ) {
              restartFunc();
            }
	    };
	  
	    if (nex == current)
			return false;
		dir = (nex < current) ? "prev" : "next";
        // Before Transition, Guarantee
		isAnimating = true
        if ( beforeTransition ) {
          beforeTransition( current, $ul.find('li.li-news:eq('+current+')'), $ul );
        }


        // After Transition, Guarantee
        // Setup the next have
        // NOTE: That current will be the new value when this is called
        // due to it being a closure!
        var newcb = function() {
          if ( cb != null ) {
            ( hoverPause == 0 ) ? cb() : setTimeout(cb, hoverPause);
          }
		  isAnimating = false;
          if ( afterTransition ) {
            afterTransition( current, $ul.find('li.li-news:eq('+current+')'), $ul );
          }
        }

		var cur = current;
        // Special Case for looping
        // If at the end and going forward, instantaneous jump to the first slide
        // If at the start and going backward, instantaneous jump to the last slide
        // NOTE: The instantaneous jump is an animate() so jQuery handles it in tune
        // with the rest of the animations, and is -1 (not 0) time so its instant.
        if ( loop ) {
          if ( (dir == "next") && (cur == lastSlide) ) {
            (vertical) ?
              $ul.animate({marginTop:0}, -1) :
              $ul.animate({marginLeft:0}, -1);
          } else if ( (dir == "prev") && (cur == 0) && (!fade)) {
            (vertical) ?
              $ul.animate({marginTop:(totalSlides-1)*slideHeight*-1}, -1) :
              $ul.animate({marginLeft:(totalSlides-1)*slideWidth*-1}, -1);
          }
        }
		
        // Dispatch jQuery Animation for the transition
        // Dispatch jQuery Animation for the transition
        // Slide horizontally, vertically, or fade
        if ( horizontal ) {
          $ul.animate( { marginLeft: (nex*slideWidth*-1)  }, speed, easing, newcb );
        } else if ( vertical ) {
          $ul.animate( { marginTop:  (nex*slideHeight*-1) }, speed, easing, newcb );
        } else {
          var curli = 'li.li-news:eq(' + cur + ')';
          var nexli = 'li.li-news:eq(' + nex + ')';
          $ul.find(curli).fadeOut("slow", function() {
            $ul.find(nexli).fadeIn("slow", newcb);
          });
        }


		var currentPage = (!loop) ? cur : ((cur == lastSlide) ? 0 : cur);
		$('#'+pageNumbersContainerId+'-page-'+currentPage).removeClass("on");		
		var nextPage = (!loop) ? nex : ((nex == lastSlide) ? 0 : nex);
		$('#'+pageNumbersContainerId+'-page-'+nextPage).addClass("on");

        // Correctly show the Next/Prev links
        // When looping they always show, so we can ignore that
        // If at the end, hide the next link
        // If at the start, hide the previous link
        // Any other case we can show both links
        if ( !loop ) {
          if ( nex <= 0 ) {
            $prev.fadeOut();
          } else if ( nex >= lastSlide ) {
            $next.fadeOut();
          } else {
            $next.fadeIn();
            $prev.fadeIn();
          }
        }

		current = nex;
      };

      //
      // Autoplay
      //
      // Note that autoplayDuration already has the transitionDuration
      // added to it (to prevent doing the addition over and over).
      // However that means that the first invokation would take
      // autoplayDuration+transitionDuration.  We remove that extra
      // wait by first doing a single setTimeout with the correct
      // time, followed by the correct setInterval.
      //
	  
      if ( autoplay ) {
        var auto = function() {
          animate('next');
          if ( !loop && current>=lastSlide ) {
            clearInterval(interval);
          }
        }
        setTimeout(function() {
		  pauseFunc();
          auto();
          interval = setInterval(auto, autoplayDuration);
        }, autoplayDuration-speed);
      }


      // Initially Hide both buttons
      $next.hide();
      $prev.hide();

      // Finally, Display the Next Link if more then one slide
      if ((loop && (totalSlides>2)) || (!loop && (totalSlides>1))) {  // agregado Rodrigo
        $next.fadeIn();
        if(loop) { $prev.fadeIn(); }
      }

    });

  };

})(jQuery);