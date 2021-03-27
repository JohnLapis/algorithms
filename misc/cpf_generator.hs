import System.Random
import Control.Monad
import Control.Monad.IO.Class

randDigits :: MonadIO m => Int -> m [Int]
randDigits n = replicateM n (randomRIO (0 :: Int, 9))

addVd1 :: Integral a => [a] -> [a]
addVd1 cpf =
  let value = mod (sum (zipWith (*) [10,9..1] cpf)) 11
  in cpf ++ [if value < 2 then 0 else 11 - value]

addVd2 :: Integral a => [a] -> [a]
addVd2 cpf =
  let value = mod (sum (zipWith (*) [11,9..1] cpf)) 11
  in cpf ++ [if value < 2 then 0 else 11 - value]

cpfGenerator :: MonadIO m => m [Int]
cpfGenerator = do
  nineDigits <- randDigits 9
  return $ addVd2 $ addVd1 nineDigits

joinListBy :: Show a => String -> [a] -> String
joinListBy _ [] = ""
joinListBy delim (x:xs) = show x ++ delim ++ joinListBy delim xs

main = do
  cpf <- cpfGenerator
  putStrLn $ joinListBy "" cpf
