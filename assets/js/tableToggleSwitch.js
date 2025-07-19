const initTableToggleSwitch = () => {
  const adminToggleContainers = document.querySelectorAll(
    '.js-admin-booking-toggle-container'
  )

  adminToggleContainers.forEach((container) => {
    const visibleInput = container.querySelector('.js-toggle-input')
    const statusTextElement = document.querySelector(
      `p[data-booking-status-text="${visibleInput.dataset.bookingId}"]`
    )

    if (!visibleInput) {
      console.error('Input missing for toggle switch: ', container)
      return
    }

    const bookingId = visibleInput.dataset.bookingId
    const toggleUrl = visibleInput.dataset.toggleUrl
    const csrfToken = visibleInput.dataset.csrfToken

    if (!bookingId || !toggleUrl || !csrfToken) {
      console.error('Missing data attributes on input: ', visibleInput)
      return
    }

    container.addEventListener('click', (event) => {
      event.preventDefault()

      const oldIsActive = visibleInput.checked
      visibleInput.checked = !oldIsActive
      updateStatusText(statusTextElement, visibleInput.checked)

      const newIsActive = visibleInput.checked
      const formData = new FormData()
      formData.append('is_active', newIsActive ? '1' : '0')
      formData.append('_token', csrfToken)

      fetch(toggleUrl, {
        method: 'POST',
        body: formData,
        headers: {
          'X-Requested-With': 'XMLHttpRequest',
        },
      })
        .then((response) => {
          if (!response.ok) {
            return response.json().then((err) => {
              console.error('Server error response:', err)
              return Promise.reject(err.message || 'Unknown server error')
            })
          }
          return response.json()
        })
        .then((data) => {
          if (data.status === 'success') {
          } else {
            console.error('Request error: ', data.message)
            visibleInput.checked = oldIsActive
            updateStatusText(statusTextElement, oldIsActive)
            alert('Erreur lors de la mise à jour: ' + data.message)
          }
        })
        .catch((error) => {
          console.error('AJAX request failed:', error)
          visibleInput.checked = oldIsActive
          updateStatusText(statusTextElement, oldIsActive)
          alert(
            'Erreur réseau ou du serveur. Veuillez réessayer. Détails: ' + error
          )
        })
    })
  })
}

const updateStatusText = (element, isActive) => {
  if (element) {
    element.textContent = isActive ? '✅ Active' : '⛔️ Inactive'
  }
}

document.addEventListener('DOMContentLoaded', initTableToggleSwitch)
document.addEventListener('turbo:load', initTableToggleSwitch)
