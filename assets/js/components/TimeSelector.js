export const TimeSelector = ($containerElement, options = {}) => {
  const { timesArray = [] } = options

  const dom = {
    container: $containerElement,
    targetInput: null,
  }

  let isValid = false

  const initializeElements = () => {
    if (!dom.container) {
      console.error('TimeSelector: Container element is missing.')
      return false
    }

    const targetInputSelector = dom.container.dataset.target
    if (!targetInputSelector) {
      console.error('TimeSelector: Missing data-target', dom.container)
      return false
    }
    dom.targetInput = document.querySelector(targetInputSelector)
    if (!dom.targetInput) {
      console.error(
        'TimeSelector: Target input element not found',
        targetInputSelector
      )
      return false
    }

    if (!Array.isArray(timesArray) || timesArray.length === 0) {
      console.error(
        'TimeSelector: timesArray option is missing or empty',
        timesArray
      )
      return false
    }

    return true
  }

  const renderTimeCards = () => {
    dom.container.innerHTML = ''

    timesArray.forEach((time) => {
      const card = document.createElement('div')
      card.classList.add('time-card-option')
      card.textContent = time
      card.dataset.value = time

      card.addEventListener('click', () => handleCardClick(card, time))

      dom.container.appendChild(card)
    })

    if (dom.targetInput.value) {
      const selectedTimeValue = dom.targetInput.value
      const existingCard = dom.container.querySelector(
        `[data-value="${selectedTimeValue}"]`
      )
      if (existingCard) {
        existingCard.classList.add('selected')
      }
    }
  }

  const handleCardClick = (clickedCard, timeValue) => {
    dom.container.querySelectorAll('.time-card-option').forEach((card) => {
      card.classList.remove('selected')
    })

    clickedCard.classList.add('selected')

    dom.targetInput.value = timeValue
  }

  return {
    init: () => {
      isValid = initializeElements()
      if (!isValid) {
        return
      }
      renderTimeCards()
    },
  }
}

export default TimeSelector
