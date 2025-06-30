document.addEventListener('DOMContentLoaded', () => {
  const button = document.querySelector('.m_TextImageBlock_button')
  const hiddenDescription = document.querySelector(
    '.m_TextImageBlock_description.hidden'
  )

  if (!button || !hiddenDescription) return

  button.addEventListener('click', () => {
    hiddenDescription.classList.remove('hidden')
    hiddenDescription.classList.add('visible')
    button.style.display = 'none'
  })
})
