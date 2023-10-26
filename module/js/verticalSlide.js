
var children = document.querySelectorAll('.hero-slider');
var progress = document.querySelectorAll('.hero-slider__progress li');
var isPlaying = 1;
var startSlide = 0;
var endSlide = children.length-1;
var currentSlide = startSlide;

var animationTime = 1500;


/* Event Listener wheel */

window.addEventListener("wheel", function() {
    var delta = Math.sign(event.deltaY);
    //console.info(delta);
    nextSlide(delta);
});



/* next slide or prev slide prev=-1 || next=1 */

function nextSlide(delta) {

    if(delta == 1 && (currentSlide<endSlide) && isPlaying == 1 && checkIsTop() ) {
        jumpTo(currentSlide+1);
    }

    else if (delta == -1 && (currentSlide>startSlide) && checkIsTop() && isPlaying == 1 ) {
        jumpTo(currentSlide-1);
    }

}


function checkIsTop() {
    if(isPhone()) {
        if(document.scrollingElement.scrollTop <= 20) {
            return true;
        } else {
            return false;
        }
    } else {
        if(document.scrollingElement.scrollTop === 0 ) {
            return true;
        } else {
            return false;
        }
    }
}

/* jump To slide number */

function jumpTo(idx) {

    if( isPlaying == 1) {
        isPlaying = 0;


        if(currentSlide < idx) {
            var temp = currentSlide;
            children[temp].closest(".hero-slider").classList.add("transition-delay-500");
            setTimeout(
                function () {
                    children[temp].closest(".hero-slider").classList.remove("transition-delay-500");
                }, 500);

            setPlayed(idx);
        }

        children[currentSlide].closest(".hero-slider").classList.remove("current");

        children[idx].closest(".hero-slider").classList.add("current");
        children[idx].closest(".hero-slider").classList.remove("played");
        progress[currentSlide].classList.remove("active");
        progress[idx].classList.add("active");
        currentSlide = idx;

        checkSlidePos();
    }
}





/* Event Listener click and drag*/

var mouseStart = 0;
document.addEventListener( 'mousedown', onMouseDown, false );
function onMouseDown(e) {
    e.preventDefault();
    mouseStart = e.y;
    console.log(mouseStart);
}


var mouseEnd = 0;
document.addEventListener( 'mouseup', onMouseUp, false );
function onMouseUp(e) {

    mouseEnd = e.y;
    console.log(mouseEnd);

    if(mouseStart > mouseEnd) {
        nextSlide(1);
    } else if (mouseStart < mouseEnd) {
        nextSlide(-1);
    }
}


/* Event Listener touch and drag*/
var touchStart = 0;
document.addEventListener( 'touchstart', ontouchDown, false );
function ontouchDown(e) {

    if(checkIsTop()) {

        var evt = (typeof e.originalEvent === 'undefined') ? e : e.originalEvent;
        var touch = evt.touches[0] || evt.changedTouches[0];

        touchStart = touch.pageY;
        console.log(touchStart);

    }
}


var touchEnd = 0;
document.addEventListener( 'touchend', ontouchUp, false );
function ontouchUp(e) {
    if(checkIsTop()) {
        var evt = (typeof e.originalEvent === 'undefined') ? e : e.originalEvent;
        var touch = evt.touches[0] || evt.changedTouches[0];

        touchEnd = touch.pageY;
        console.log(touchEnd);

        if(touchStart > touchEnd) {
            nextSlide(1);
        } else if (touchStart < touchEnd) {
            nextSlide(-1);
        }
    }
}





/* Check Slide position */

function checkSlidePos() {
    if(currentSlide != endSlide) {
        document.body.classList.remove("scrollAgain");
    }

    if(currentSlide == endSlide) {

        setTimeout(function() {
            if (isPhone() === true) {
                var i = 5;

                var int = setInterval(function() {
                    window.scrollTo(0, i);
                    i += 5;
                    if (i >= 150) clearInterval(int);
                }, 20);
            }else{
                window.scrollBy({
                    top: 100, // could be negative value
                    left: 0,
                    behavior: 'smooth'
                });
            }
        },animationTime+100);
    }


    setTimeout(
        function () {
            console.log("setTime");
            isPlaying = 1;
            if(currentSlide == endSlide) {
                document.body.classList.add("scrollAgain");
            }
        }, animationTime);
}


/* Set Classes */

function setPlayed(idx) {
    for(var i=0; i<=children.length-1 ; i++) {
        if(i <= idx ) {
            children[i].closest(".hero-slider").classList.add("played");
        } else {
            children[i].closest(".hero-slider").classList.remove("played");
        }
    }
}

/* is Phone */
function isPhone() {
    if(navigator.userAgent.match(/(iPod|iPhone|iPad|Android)/)) {
        return true;
    } else {
        return false;
    }
}



