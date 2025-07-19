/**
 * Generates an array of time strings (HH:MM) for a given range and interval.
 * @param {number} startHour
 * @param {number} endHour
 * @param {number} intervalMinutes
 * @returns {string[]}
 */
export const generateTimes = (startHour, endHour, intervalMinutes) => {
  const times = []
  for (let h = startHour; h < endHour; h++) {
    for (let m = 0; m < 60; m += intervalMinutes) {
      if (h === endHour - 1 && m >= intervalMinutes) {
        break
      }
      times.push(`${String(h).padStart(2, '0')}:${String(m).padStart(2, '0')}`)
    }
  }
  return times
}

export const ARRIVAL_TIMES = generateTimes(8, 14, 30) // 08:00 to 13:30
export const DEPARTURE_TIMES = generateTimes(11, 19, 30) // 11:00 to 18:30
