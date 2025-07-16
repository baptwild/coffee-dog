const initBookingDateTime = () => {
  function getNextWeekdays() {
    const weekdays = []
    let date = new Date()
    let count = 0
    while (count < 10) {
      const day = date.getDay()
      // Du Mardi au Samedi
      if (day >= 2 && day <= 5) {
        weekdays.push(new Date(date))
        count++
      }
      date.setDate(date.getDate() + 1)
    }
    return weekdays
  }

  const dateContainer = document.querySelector('.date-cards')
  const dateInput = document.querySelector('.js-datepicker')

  if (dateContainer && dateInput) {
    dateContainer.innerHTML = ''

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

      option.addEventListener('click', () => {
        document
          .querySelectorAll('.date-cards .date-card-option')
          .forEach((card) => card.classList.remove('selected'))
        option.classList.add('selected')
        dateInput.value = option.dataset.value
      })

      dateContainer.appendChild(option)
    })

    if (dateInput.value) {
      const selectedDateValue = dateInput.value
      const existingCard = dateContainer.querySelector(
        `[data-value="${selectedDateValue}"]`
      )
      if (existingCard) {
        existingCard.classList.add('selected')
      }
    }
  }

  const arrivalTimes = []
  for (let h = 8; h < 14; h++) {
    arrivalTimes.push(`${String(h).padStart(2, '0')}:00`)
    if (h < 14) arrivalTimes.push(`${String(h).padStart(2, '0')}:30`)
  }

  const departureTimes = []
  for (let h = 11; h < 19; h++) {
    departureTimes.push(`${String(h).padStart(2, '0')}:00`)
    if (h < 19) departureTimes.push(`${String(h).padStart(2, '0')}:30`)
  }

  document.querySelectorAll('.arrival-time-cards').forEach((container) => {
    container.innerHTML = ''

    const targetInput = document.querySelector(container.dataset.target)
    if (!targetInput) return

    arrivalTimes.forEach((time) => {
      const card = document.createElement('div')
      card.classList.add('time-card-option')
      card.textContent = time
      card.dataset.value = time

      card.addEventListener('click', () => {
        container
          .querySelectorAll('.time-card-option')
          .forEach((card) => card.classList.remove('selected'))
        card.classList.add('selected')
        targetInput.value = time
      })

      container.appendChild(card)
    })

    if (targetInput.value) {
      const selectedTimeValue = targetInput.value
      const existingCard = container.querySelector(
        `[data-value="${selectedTimeValue}"]`
      )
      if (existingCard) {
        existingCard.classList.add('selected')
      }
    }
  })

  document.querySelectorAll('.departure-time-cards').forEach((container) => {
    container.innerHTML = ''

    const targetInput = document.querySelector(container.dataset.target)
    if (!targetInput) return

    departureTimes.forEach((time) => {
      const card = document.createElement('div')
      card.classList.add('time-card-option')
      card.textContent = time
      card.dataset.value = time

      card.addEventListener('click', () => {
        container
          .querySelectorAll('.time-card-option')
          .forEach((card) => card.classList.remove('selected'))
        card.classList.add('selected')
        targetInput.value = time
      })

      container.appendChild(card)
    })

    if (targetInput.value) {
      const selectedTimeValue = targetInput.value
      const existingCard = container.querySelector(
        `[data-value="${selectedTimeValue}"]`
      )
      if (existingCard) {
        existingCard.classList.add('selected')
      }
    }
  })
}

document.addEventListener('turbo:load', initBookingDateTime)
