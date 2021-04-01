import Data.Char
import Data.List

operators = [("+", (+)),
             ("-", (-)),
             ("*", (*))
            ]

isFunction :: Char -> Bool
isFunction = not . isDigit

solveRPN :: [String] -> Int
solveRPN [x] = read x :: Int
solveRPN expr =
  let (Just funcIdx) =  findIndex (isFunction . head) expr
      (subExpr, afterExpr) = splitAt (funcIdx + 1) expr
      (beforeExpr, [num1, num2, func]) = splitAt (length subExpr - 3) subExpr
      x = read num1 :: Int
      y = read num2 :: Int
      (Just op) = lookup func operators
  in solveRPN $ beforeExpr ++ [show $ op x y] ++ afterExpr


parseRPN :: String -> [String]
parseRPN expr = words expr

main = do
  putStr "RPN expression: "
  expr <- getLine
  putStr "Result: "
  print . solveRPN . parseRPN $ expr
  main
