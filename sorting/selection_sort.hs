_minimum :: [Int] -> (Int, Int)
_minimum [n] = (n, 0)
_minimum (n:ns) = let (m, idx) = _minimum ns
                 in if n < m then (n, 0)
                    else (m, idx + 1)

sort :: [Int] -> [Int]
sort [] = []
sort [a] = [a]
sort (n:ns) = let (m, idx) = _minimum (n:ns)
              in if n == m then n:(sort ns)
                 else m : (sort $ (take (idx-1) ns) ++ n : drop (idx) ns)
