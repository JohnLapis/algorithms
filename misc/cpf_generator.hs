import System.Random
import Control.Monad
import Control.Monad.IO.Class
import Data.List

randDigits :: MonadIO m => Int -> m [Int]
randDigits n = replicateM n (randomRIO (0 :: Int, 9))

genVd1 :: Integral a => [a] -> a
genVd1 cpf = if value < 2 then 0 else 11 - value
  where value = mod (sum (zipWith (*) [10,9..1] cpf)) 11

genVd2 :: Integral a => [a] -> a
genVd2 cpf = if value < 2 then 0 else 11 - value
  where value = mod (sum (zipWith (*) [11,9..1] cpf)) 11

cpfGenerator :: MonadIO m => m [Int]
cpfGenerator = do
  digits <- randDigits 9
  return $ digits ++ [genVd1 digits, genVd2 digits]

main = do
  cpf <- cpfGenerator
  putStrLn . intercalate "" . map show $ cpf
