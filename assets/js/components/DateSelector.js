import { getNextWeekdays } from '../utils/dateUtils.js'

export const DateSelector = ($containerElement) => {
  const dom = {
    container: $containerElement,
    dateInput: document.querySelector('.js-datepicker'),
  }

  let isValid = false

  const initializeElements = () => {
    if (!dom.container) {
      console.error('DateSelector: Container element (.date-cards) is missing.')
      return false
    }
    if (!dom.dateInput) {
      console.error(
        'DateSelector: Target date input (.js-datepicker) is missing.'
      )
      return false
    }
    return true
  }

  const renderDateCards = () => {
    dom.container.innerHTML = ''

    getNextWeekdays().forEach((date) => {
      const option = document.createElement('div')
      option.classList.add('date-card-option')

      const day = date.toLocaleDateString('fr-FR', { weekday: 'short' })
      const num = date.toLocaleDateString('fr-FR', {
        day: '2-digit',
        month: 'short',
      })
      option.innerHTML = `<div>${day}</div><div>${num}</div>`

      option.dataset.value = date.toISOString().split('T')[0]

      option.addEventListener('click', () => handleCardClick(option))

      dom.container.appendChild(option)
    })

    if (dom.dateInput.value) {
      const selectedDateValue = dom.dateInput.value
      const existingCard = dom.container.querySelector(
        `[data-value="${selectedDateValue}"]`
      )
      if (existingCard) {
        existingCard.classList.add('selected')
      }
    }
  }

  const handleCardClick = (clickedCard) => {
    dom.container.querySelectorAll('.date-card-option').forEach((card) => {
      card.classList.remove('selected')
    })

    clickedCard.classList.add('selected')

    dom.dateInput.value = clickedCard.dataset.value
  }

  return {
    init: () => {
      isValid = initializeElements()
      if (!isValid) {
        return
      }
      renderDateCards()
    },
  }
}

export default DateSelector
