(defn merge [right left]
  (cond
    (empty? left) right
    (empty? right) left
    :else
    (if (< (first left) (first right))
      (cons (first left) (merge (rest left) right))
      (cons (first right) (merge left (rest right))))))

(defn mergesort [list]
  (if (empty? (rest list))
   list
   (let [halves (split-at (/ (count list) 2) list)
         left (halves 0)
         right (halves 1)]
   (merge (mergesort left) (mergesort right)))))

(defn main []
  (let [list (shuffle '(0 1 2 3 4 5 6 7 8 9))
        sorted-list (mergesort list)]
    (if (= sorted-list (sort list))
      sorted-list
      (cons "error" sorted-list))))


(println (main))
