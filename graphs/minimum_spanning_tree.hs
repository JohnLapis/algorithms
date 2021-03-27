import System.Environment
import Control.Monad
import qualified Data.Set as Set
import Data.List

data Node' = Node String deriving Show
data Edge' = Edge (Int, (Node, Node)) deriving Show
data Graph' = Graph ([Node], [Edge]) deriving Show

type Node = String
type Edge = (Int, (Node, Node))
type Graph = ([Node], [Edge])
-- data Edge = Edge
--   { weight :: Int
--   , nodes :: (Node, Node)
--   }
-- data Graph = Graph
--   { edges :: [Edge]
--   , nodes :: [Node]
--   }


isNodesStart :: String -> Bool
isNodesStart = (== "Nodes:")

isEdgesStart :: String -> Bool
isEdgesStart = (== "Edges:")

takeBetween :: (a -> Bool) -> (a -> Bool) -> [a] -> [a]
takeBetween startP endP = takeWhile (not . endP) . dropWhile (not . startP)

isSpanningGraph :: Graph -> Graph -> Bool
isSpanningGraph (nodes1, _) (nodes2, _) = Set.fromList nodes1 == Set.fromList nodes2

isTree :: Graph -> Bool
isTree graph = True -- IMP

isSpanningTree :: Graph -> Graph -> Bool
isSpanningTree graph sgraph = isTree sgraph && isSpanningGraph graph sgraph

totalWeight :: Graph -> Int
totalWeight (_, edges) = sum $ map (\(weight, _) -> weight) edges

genMST :: Graph -> Graph
genMST graph = graph -- IMP

parseGraph :: String -> Graph
parseGraph text
  | text == "" = ([], [])
  | otherwise = (nodes, edges) where
      getNodes = tail . takeBetween isNodesStart isEdgesStart
      getEdges = tail . dropWhile (not . isEdgesStart)

      textLines = lines text
      nodes = filter (/= "") $ getNodes textLines
      edges = flip map
              (filter (/= "") $ getEdges textLines)
              (\line -> let [weight, n1, n2] = words line
                        in (read weight :: Int, (n1, n2)))

printEdge :: Edge -> IO ()
printEdge (weight, (node1, node2)) = do
    putStrLn $ "(" ++ show weight ++  ", (" ++ node1 ++ ", " ++ node2 ++ "))"

printGraph :: Graph -> IO ()
printGraph (nodes, edges) = do
  putStrLn "Nodes:"
  putStrLn $ "(" ++ intercalate ", " nodes ++ ")"
  putStrLn "Edges:"
  mapM_ printEdge edges

main = do
  (filename:_) <- getArgs
  content <- readFile filename
  let graph = parseGraph content
      mst = genMST graph
  printGraph mst
  putStrLn $ "Total weight of generated tree: " ++ show (totalWeight mst)
  putStrLn $ if isSpanningTree graph mst
             then "The generated tree is a spanning tree."
             else "The generated tree is NOT a spanning tree."





-- parseGraph' =
      -- numLines = length textLines
      -- (Just nodesStart) = findIndex isNodesStart textLines
      -- (Just edgesStart) = findIndex isEdgesStart textLines
      -- nodes = takeWhile (not . isEdgesStart) . drop nodeStart + 1 $ textLines

      -- getNodes = takeWhile (not . isEdgesStart) . tail . dropWhile (not . isNodeStart)
