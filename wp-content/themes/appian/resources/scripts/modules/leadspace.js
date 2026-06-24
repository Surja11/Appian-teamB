

const scrollEllipse = document.querySelector('.home-leadspace__scroll-ellipse');
const outerEllipse = document.querySelector('.home-leadspace__outer-ellipse');

// listening for scroll event listener
if (scrollEllipse){
window.addEventListener('scroll', () => {

    // getting the pixels scrolled by user
    const scrolled = window.scrollY;
    // console.log(scrolled)


    // defining the total scroll distance needed to complete one full rotation
    const total = window.innerHeight * 2;

    // calculating scroll progress which is between 0 and 1
    const progress = Math.min(scrolled / total, 1);

    // calculating rotatiion degree
    const rotation = -progress * 360;

    scrollElipse.style.transform = `rotate(${rotation}deg)`;
});
}