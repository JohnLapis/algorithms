quicksort :: (Ord a) => [a] -> [a]
quicksort [] = []
quicksort (x:xs) =
  let left = quicksort [n | n <- xs, n <= x]
      right = quicksort [n | n <- xs, n > x]
  in left ++ [x] ++ right
