<?php
require_once('matrix.php');

echo "Given: ";
$m = new Matrix([
    [5, 7],
    [6, 8],
]);
print_matrix($m);
echo "Transpose: ";
print_matrix(transpose($m));
echo "Det: " . det($m) . "\n";
echo "Det of transpose: " . det(transpose($m)) . "\n";

echo "\n";

echo "Given: ";
$m = new Matrix([
    [1, 9, 3],
    [2, 5, 4],
    [3, 7, 8],
]);
print_matrix($m);

echo "Minor of entry (2, 2): ";
print_matrix(minor(2, 2, $m));

echo "Cofactor matrix: ";
$cofm = cofactor_matrix($m);
print_matrix($cofm);
if ($cofm->rows != (new Matrix([[12, -4, -1], [-51, -1, 20], [21, 2, -13]]))->rows) {
    echo "Incorrect!\n";
}

echo "Multiplied by 2: ";
print_matrix(scalar_mult(2, $m));
if (scalar_mult(2, $m)->rows != mult(2, $m)->rows) echo "Incorrect!\n";

echo "Multiplied by itself twice: ";
print_matrix(mpow($m, 2));
if (mpow($m, 2)->rows != mult($m, $m)->rows) echo "Incorrect!\n";

echo "Inverse matrix: ";
$invm = inverse($m);
print_matrix($invm);

echo "Multiplication of matrix with its inverse: ";
print_matrix(mult($m, $invm));

echo "Cross product of rows of matrix: ";
$res = cross(cross($m->rows[0], $m->rows[1]), $m->rows[2]);
print_vector($res);
if ($res != [107, -207,  141]) echo "Incorrect!\n";

echo "\n";

$m = diag_matrix([1, 1, 1, 1, 1, 1, 1, 1, 1]);
echo "Diag matrix: ";
print_matrix($m);
if ($m->rows != id_matrix(9)->rows) echo "Incorrect!\n";
if (is_diagonal($m)) echo "It's diagonal.\n";
else echo "Incorrect!\n";

echo "\n";

echo "Given: ";
$n = new Matrix([
    [1, 0, 0, 0, 0, 0, 0, 0, 0],
    [1, 2, 0, 0, 0, 0, 0, 0, 0],
    [1, 2, 3, 0, 0, 0, 0, 0, 0],
    [1, 2, 3, 4, 0, 0, 0, 0, 0],
    [1, 2, 3, 4, 5, 0, 0, 0, 0],
    [1, 2, 3, 4, 5, 6, 0, 0, 0],
    [1, 2, 3, 4, 5, 6, 7, 0, 0],
    [1, 2, 3, 4, 5, 6, 7, 8, 0],
    [1, 2, 3, 4, 5, 6, 7, 8, 9],
]);
$m = add($n, $m);
print_matrix($m);
if (is_lower_triangle($m)) echo "It's lower triangle.\n";
else echo "Incorrect!\n";
