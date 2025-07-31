
//--- navbar -- //

document.addEventListener("DOMContentLoaded", function () {
  const header = document.querySelector(".nav-topbar");
  const toggleClass = "scroll-top-fixed";
  const toggleHeaderClass = () => {
    if (window.scrollY > 50) {
      header.classList.add(toggleClass);
    } else {
      header.classList.remove(toggleClass);
    }
  };

  toggleHeaderClass();
  window.addEventListener("scroll", toggleHeaderClass);
});




//---- owl_carousel start ----//

$(document).ready(function() {
    

});


//---- owl_carousel end ----//

//---- floating label start ----//



//---- floating label end ----//


//----- GSAP Scroll effect ----//

// gsap.registerPlugin(ScrollTrigger);

// ScrollTrigger.matchMedia({
//   "(min-width: 1200px)": function() {
//     gsap.utils.toArray(".parallax-scroll").forEach((section, i) => {
//       ScrollTrigger.create({
//         trigger: section,
//         start: "top top",
//         pin: true,
//         pinSpacing: false,
//         onUpdate: (self) => {
//           const progress = self.progress; 
//           gsap.to(section, { opacity: 1 - progress, overwrite: true });
//         }
//       });
//     });
//   }
// });





function animateCounter(element, start, end, duration) {
        const range = end - start;
        const startTime = new Date().getTime();

        function updateCounter() {
            const currentTime = new Date().getTime();
            const progress = Math.min((currentTime - startTime) / duration, 1);
            const currentValue = Math.floor(progress * range + start);
            element.innerText = currentValue.toLocaleString(); // Format with commas

            if (progress < 1) {
                requestAnimationFrame(updateCounter);
            }
        }

        requestAnimationFrame(updateCounter);
    }

    // Scroll-trigger setup
    const counterSection = document.getElementById('counter-section');
    const counterSectionClinic = document.getElementById('counter-section-clinic');
    const counterElement = document.getElementById('counter');
    const counterElementClinic = document.getElementById('counter-clinic');
    let counterStarted = false;
    let counterStartedClinic = false;

    // Intersection Observer to detect when the section enters the viewport
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting && !counterStarted) {
                counterStarted = true; // Ensure the counter only starts once
                animateCounter(counterElement, 1, 10000, 2000); // Adjust end and duration as needed
            }
        });
    }, {
        threshold: 0.5 // Trigger when 50% of the section is visible
    });

    observer.observe(counterSection);
// Intersection Observer to detect when the section enters the viewport
    const observerx = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting && !counterStartedClinic) {
                counterStartedClinic = true; // Ensure the counter only starts once
                animateCounter(counterElementClinic, 1, 100, 2000); // Adjust end and duration as needed
            }
        });
    }, {
        threshold: 0.5 // Trigger when 50% of the section is visible
    });

    observerx.observe(counterSectionClinic);

// carousel appointment modal

// const carousel = Carousel('#carouselExampleFade', {
//   interval: false,
//   ride: 'carousel'
// });

// end

