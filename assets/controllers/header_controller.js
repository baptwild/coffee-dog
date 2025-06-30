import { Controller } from '@hotwired/stimulus'

export default class extends Controller {
  connect() {
    this.header = this.element

    if (this.header.classList.contains('l_Header-transparent')) {
      window.addEventListener('scroll', this.toggleTransparency)
    }
  }

  disconnect() {
    window.removeEventListener('scroll', this.toggleTransparency)
  }

  toggleTransparency = () => {
    if (window.scrollY > 10) {
      this.header.classList.remove('l_Header-transparent')
    } else {
      this.header.classList.add('l_Header-transparent')
    }
  }
}
