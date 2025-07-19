import './bootstrap.js'

import './styles/main.scss'
import 'bootstrap-icons/font/bootstrap-icons.css'

// Import JS files
import HeaderScroll from './js/components/HeaderScroll.js'
import MobileMenu from './js/components/MobileMenu.js'
import TextImageBlockReveal from './js/components/TextImageBlockReveal.js'

import ToggleSwitchForm from './js/components/ToggleSwitchForm.js'
import ToggleSwitchTable from './js/components/ToggleSwitchTable.js'

import DateSelector from './js/components/DateSelector.js'
import TimeSelector from './js/components/TimeSelector.js'

import { ARRIVAL_TIMES, DEPARTURE_TIMES } from './js/utils/timeUtils.js'

// Initialize JavaScript components
const initializeComponents = () => {
  console.log('Initializing JavaScript components...')

  // HeaderScroll
  const headerElement = document.querySelector('.l_Header-transparent')
  if (headerElement) {
    const component = HeaderScroll(headerElement)
    component.init()
  }

  // MobileMenu
  const mobileMenuElement = document.querySelector('.m_MobileMenu')
  if (mobileMenuElement) {
    const component = MobileMenu(mobileMenuElement)
    component.init()
  }

  // ToggleSwitchForm
  document
    .querySelectorAll('.js-form-toggle-container')
    .forEach((container) => {
      const component = new ToggleSwitchForm(container)
      component.init()
    })

  // ToggleSwitchTable
  document
    .querySelectorAll('.js-admin-booking-toggle-container')
    .forEach((container) => {
      const component = new ToggleSwitchTable(container)
      component.init()
    })

  // Date and Time
  const dateSelectorContainer = document.querySelector('.date-cards')
  if (dateSelectorContainer) {
    const component = DateSelector(dateSelectorContainer)
    component.init()
  }

  document.querySelectorAll('.arrival-time-cards').forEach((container) => {
    const component = TimeSelector(container, { timesArray: ARRIVAL_TIMES })
    component.init()
  })

  document.querySelectorAll('.departure-time-cards').forEach((container) => {
    const component = TimeSelector(container, { timesArray: DEPARTURE_TIMES })
    component.init()
  })

  // TextImageBlockReveal
  document.querySelectorAll('.m_TextImageBlock').forEach((container) => {
    const component = TextImageBlockReveal(container)
    component.init()
  })
}

document.addEventListener('turbo:load', initializeComponents)
