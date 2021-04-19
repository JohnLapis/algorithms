<?php

function init_matrix(int $row_dim): array {
    $matrix = [];
    for ($i = 0; $i < $row_dim; ++$i) {
        $matrix[$i] = [];
    }
    return $matrix;
}

function init_vector(int $dim): array {
    $vector = [];
    for ($i = 0; $i < $dim; ++$i) {
        $vector[$i] = 0;
    }
    return $vector;
}

function scale_vector(float $a, array $v): array {
    $vector = [];
    for ($i = 0; $i < count($v); ++$i) {
        $vector[$i] = $a * $v[$i];
    }
    return $vector;
}

function cross(array $a, array $b): array {
    if (count($a) != 3 && count($b) != 3) {
        throw new Exception("Both vectors must have 3 dimensions.");
    }

    return [
        $a[1] * $b[2] - $a[2] * $b[1],
        $a[2] * $b[0] - $a[0] * $b[2],
        $a[0] * $b[1] - $a[1] * $b[0],
    ];
}

function dot(array $a, array $b): int {
    if (count($a) != count($b)) {
        throw new Exception("Multiplication of vectors of different dimensions.");
    }

    $result = 0;
    for ($i = 0; $i < count($a); ++$i) {
        $result += $a[$i] * $b[$i];
    }
    return $result;
}

function vector_add(array $a, array $b): array {
    if (count($a) != count($b)) {
        throw new Exception("Addition of vectors of different dimensions.");
    }

    $c = [];
    for ($i = 0; $i < count($a); ++$i) {
        $c[$i] = $a[$i] + $b[$i];
    }
    return $c;
}


function norm(array $a): float {
    return sqrt($a, $a);
}

function col(int $j, Matrix $m): array {
    $jth_col = [];
    for ($i = 0; $i < $m->row_dim; ++$i) {
        $jth_col[$i] = $m->rows[$i][$j];
    }
    return $jth_col;
}

function minor(int $row_idx, int $col_idx, Matrix $m): Matrix {
    $matrix = init_matrix($m->row_dim - 1);

    $cur_row = 0;
    for ($i = 0; $i < $m->row_dim; ++$i) {
        if ($i == $row_idx) continue;
        $cur_col = 0;
        for ($j = 0; $j < $m->col_dim; ++$j) {
            if ($j == $col_idx) continue;
            $matrix[$cur_row][$cur_col] = $m->rows[$i][$j];
            $cur_col++;
        }
        $cur_row++;
    }

    return new Matrix($matrix);
}

function cofactor(int $i, int $j, Matrix $m): float {
    return (-1) ** ($i + $j) * det(minor($i, $j, $m));
}

function det(Matrix $m): float {
    if ($m->row_dim == 1) return $m->rows[0][0];

    $sum = 0;
    $j = 0;
    $first_col = col($j, $m);
    for ($i = 0; $i < $m->row_dim; ++$i) {
        $sum += $first_col[$i] * cofactor($i, $j, $m);
    }
    return $sum;
}

function cofactor_matrix(Matrix $m): Matrix {
    $matrix = init_matrix($m->row_dim);

    for ($i = 0; $i < $m->row_dim; ++$i) {
        for ($j = 0; $j < $m->col_dim; ++$j) {
            $matrix[$i][$j] = cofactor($i, $j, $m);
        }
    }

    return new Matrix($matrix);
}

function transpose(Matrix $m): Matrix {
    $matrix = [];

    for ($i = 0; $i < $m->row_dim; ++$i) {
        $matrix[$i] = [];
    }

    for ($i = 0; $i < $m->row_dim; ++$i) {
        for ($j = 0; $j < $m->col_dim; ++$j) {
            $matrix[$j][$i] = $m->rows[$i][$j];
        }
    }
    return new Matrix($matrix);
}

function is_diagonal(Matrix $m): bool {
    $matrix = $m->rows;

    for ($i = 0; $i < $m->row_dim; ++$i) {
        $matrix[$i][$i] = 0;
    }

    for ($i = 0; $i < $m->row_dim; ++$i) {
        for ($j = 0; $j < $m->col_dim; ++$j) {
            if ($matrix[$i][$j] != 0) return false;
        }
    }

    return true;
}

function is_upper_triangle(Matrix $m): bool {
    $matrix = $m->rows;

    for ($i = 0; $i < $m->row_dim; ++$i) {
        for ($j = 0; $j < $i && $j < $m->col_dim; ++$j) {
            if ($matrix[$i][$j] != 0) return false;
        }
    }

    return true;
}

function is_lower_triangle(Matrix $m): bool {
    return is_upper_triangle(transpose($m));
}

function is_singular(Matrix $m): bool {
    return det($m) == 0;
}

function matrix_add(Matrix $a, Matrix $b): Matrix {
    if ($a->row_dim != $b->row_dim || $a->col_dim != $b->col_dim) {
        throw new Exception("Addition of matrices with different row and column dimensions.");
    }

    $matrix = init_matrix($a->row_dim);
    for ($i = 0; $i < $a->row_dim; ++$i) {
        $matrix[$i] = vector_add($a->rows[$i], $b->rows[$i]);
    }
    return new Matrix($matrix);
}

function matrix_mult(Matrix $a, Matrix $b): Matrix {
    if ($a->col_dim != $b->row_dim) {
        throw new Exception("Multiplication of matrices with different row and column dimensions.");
    }

    $matrix = init_matrix($a->row_dim);
    $bt = transpose($b);

    for ($i = 0; $i < $a->row_dim; ++$i) {
        $row_a  = $a->rows[$i];
        for ($j = 0; $j < $b->col_dim; ++$j) {
            $row_bt = $bt->rows[$j];
            $matrix[$i][$j] = dot($row_a, $row_bt);
        }
    }

    return new Matrix($matrix);
}

function mpow(Matrix $m, int $n): Matrix {
    if ($n == 0) return id_matrix($m->row_dim);
    if ($n == 1) return $m;
    return mpow(matrix_mult($m, $m), $n-1);
}

function scalar_mult(float $a, Matrix $m): Matrix {
    $matrix = init_matrix($m->row_dim);

    for ($i = 0; $i < $m->row_dim; ++$i) {
        $row  = $m->rows[$i];
        $matrix[$i] = scale_vector($a, $row);
    }

    return new Matrix($matrix);
}

function add($a, $b) {
    if (is_array($a)) return vector_add($a, $b);
    else if (is_a($a, 'Matrix')) return matrix_add($a, $b);
    else throw new Exception("Arguments should be either vectors or matrices.");
}

function sub($a, $b) {
    if (is_array($a)) return vector_add($a, mult(-1, $b));
    else if (is_a($a, 'Matrix')) return matrix_add($a, mult(-1, $b));
    else throw new Exception("Arguments should be either vectors or matrices.");
}

function mult($a, $b) {
    if (is_array($b)) return scale_vector($a, $b);
    else if (is_a($b, 'Matrix')) return is_numeric($a) ?
                                     scalar_mult($a, $b) : matrix_mult($a, $b);
    else throw new Exception("Argument b should be either a vector or a matrix.");
}

function inverse(Matrix $m): Matrix {
    $det_m = det($m);
    if ($det_m == 0) throw new Exception("Matrix is singular");
    return mult(1 / $det_m, transpose(cofactor_matrix($m)));
}

function id_matrix(int $dim): Matrix {
    $matrix = init_matrix($dim);

    for ($i = 0; $i < $dim; ++$i) {
        $matrix[$i] = init_vector($dim);
        $matrix[$i][$i] = 1;
    }

    return new Matrix($matrix);
}

function diag_matrix(array $vector): Matrix {
    $dim_matrix = count($vector);
    $matrix = init_matrix($dim_matrix);

    for ($i = 0; $i < $dim_matrix; ++$i) {
        $matrix[$i] = init_vector($dim_matrix);
        $matrix[$i][$i] = $vector[$i];
    }

    return new Matrix($matrix);
}

function print_vector(array $v) {
    echo "[" . implode(", ", $v) . "]\n";
}

function print_matrix(Matrix $m) {
    echo "[\n";
    foreach ($m->rows as $row) {
        echo "  ";
        print_vector($row);
    }
    echo "]\n";
}

class Matrix {
    public static function is_valid(array $rows): bool {
        if (count($rows) == 1) return count($rows[0]) == 1;

        $col_lengths = array_map('count', $rows);
        $col_dim = $col_lengths[0];

        foreach ($col_lengths as $length) {
            if ($length != $col_dim) return false;
        }

        return true;
    }
    public function __construct(array $rows) {
        if (!Matrix::is_valid($rows)) {
            throw new Exception("Rows don't have the same length.");
        }

        $this->rows = $rows;
        $this->row_dim = count($rows);
        $this->col_dim = count($rows[0]);
    }
}
