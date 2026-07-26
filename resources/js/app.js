import './bootstrap'

const menuButton = document.querySelector('[data-mobile-menu-button]')
const mobileMenu = document.querySelector('[data-mobile-menu]')

if (menuButton && mobileMenu) {
    const closeMenu = () => {
        mobileMenu.hidden = true
        menuButton.setAttribute('aria-expanded', 'false')
    }

    menuButton.addEventListener('click', () => {
        const isOpening = mobileMenu.hidden
        mobileMenu.hidden = !isOpening
        menuButton.setAttribute('aria-expanded', String(isOpening))
    })

    mobileMenu.querySelectorAll('a').forEach((link) => link.addEventListener('click', closeMenu))

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            closeMenu()
            menuButton.focus()
        }
    })
}

document.querySelectorAll('[data-hero-carousel]').forEach((carousel) => {
    const slides = [...carousel.querySelectorAll('[data-hero-slide]')]
    const dots = [...carousel.querySelectorAll('[data-hero-dot]')]

    if (slides.length < 2) {
        return
    }

    const status = carousel.querySelector('[data-hero-status]')
    let activeIndex = 0
    let timer

    const showSlide = (nextIndex, announce = true) => {
        activeIndex = (nextIndex + slides.length) % slides.length

        slides.forEach((slide, index) => {
            const isActive = index === activeIndex
            slide.setAttribute('aria-hidden', String(!isActive))
            slide.toggleAttribute('inert', !isActive)
            slide.classList.toggle('is-active', isActive)
        })

        dots.forEach((dot, index) => dot.setAttribute('aria-selected', String(index === activeIndex)))

        if (announce && status) {
            status.textContent = `Slide ${activeIndex + 1} of ${slides.length}`
        }
    }

    const scheduleNext = () => {
        window.clearTimeout(timer)

        if (document.hidden) {
            return
        }

        timer = window.setTimeout(
            () => {
                showSlide(activeIndex + 1, false)
                scheduleNext()
            },
            Number(slides[activeIndex].dataset.duration || 3000)
        )
    }

    const move = (direction) => {
        showSlide(activeIndex + direction)
        scheduleNext()
    }

    carousel.querySelector('[data-hero-previous]')?.addEventListener('click', () => move(-1))
    carousel.querySelector('[data-hero-next]')?.addEventListener('click', () => move(1))
    dots.forEach((dot, index) =>
        dot.addEventListener('click', () => {
            showSlide(index)
            scheduleNext()
        })
    )

    carousel.addEventListener('keydown', (event) => {
        if (event.key === 'ArrowLeft') {
            move(-1)
        }

        if (event.key === 'ArrowRight') {
            move(1)
        }
    })
    document.addEventListener('visibilitychange', scheduleNext)

    showSlide(0, false)
    scheduleNext()
})
