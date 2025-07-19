/**
 * Generates an array of the next 10 available weekdays (Tuesday to Friday).
 * @returns {Date[]}
 */
export const getNextWeekdays = () => {
  const weekdays = []
  let date = new Date()
  let count = 0

  date.setHours(0, 0, 0, 0)

  while (count < 10) {
    const day = date.getDay()
    // Tuesday (2) to Friday (5)
    if (day >= 2 && day <= 5) {
      weekdays.push(new Date(date))
      count++
    }
    date.setDate(date.getDate() + 1)
  }
  return weekdays
}
