const updateStatusText = (element, isActive) => {
  if (element) {
    element.textContent = isActive ? '✅ Active' : '⛔️ Inactive'
  }
}

export default updateStatusText
