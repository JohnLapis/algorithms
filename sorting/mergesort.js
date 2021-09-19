function merge(l, r) {
  let a = []
  let i = j = 0
  for (let k = 0; i < l.length && j < r.length; k++) {
    if (l[i] <= r[j]) {
      a[k] = l[i]
      i++
    } else {
      a[k] = r[j]
      j++
    }
  }

  return a.concat(i == l.length ? r.slice(j) : l.slice(i))
}


function sort(array) {
  if (array.length <= 1) return array

  const mid = Math.floor(array.length / 2)
  const l = sort(array.slice(0, mid))
  const r = sort(array.slice(mid))
  return merge(l, r)
}
