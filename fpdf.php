?php

// FPDF class
class FPDF {

    // Public variables
    public $page;
    public $orientation;
    public $unit;
    public $size;
    public $font;
    public $size_font;
    public $ln;
    public $x;
    public $y;
    public $text;

    // Constructor
    function __construct($orientation = 'P', $unit = 'mm', $size = 'A4') {
        $this->page = 0;
        $this->orientation = $orientation;
        $this->unit = $unit;
        $this->size = $size;
        $this->SetMargins(20, 10, 20);
        $this->SetAutoPageBreak(true, 20);
        $this->SetFont('Arial', 'B', 12);
    }

    // Add a new page
    function AddPage() {
        $this->page++;
        $this->x = 0;
        $this->y = 0;
        $this->Ln(20);
    }

    // Set the font
    function SetFont($font, $style = '', $size = 12) {
        $this->font = $font;
        $this->size_font = $size;
    }

    // Set the margins
    function SetMargins($left, $top, $right) {
        $this->left = $left;
        $this->top = $top;
        $this->right = $right;
    }

    // Set the auto page break
    function SetAutoPageBreak($auto, $margin) {
        $this->auto_page_break = $auto;
        $this->margin = $margin;
    }

    // Write text
    function Write($text, $align = 'L') {
        $this->text = $text;
        $this->align = $align;
        $this->WriteMultiCell($this->x, $this->y, $this->text, 0, $this->align);
    }

    // Write a multi-cell
    public function WriteMultiCell($w, $h, $txt, $border = 0, $align = 'L', $fill = false) {
        $cw = $this->GetCharWidth($txt);
        $w = $w * $cw;
        $this->x += $w;
    }

    // Get the character width
    public function GetCharWidth($c) {
        // TODO: Implement this method
        return 0;
    }

    // Output the PDF file
    function Output($file = '') {
        if ($file == '') {
            $this->Output('I');
        } else {
            $this->Output('F', $file);
        }
    }

    // Move the cursor down by a specified number of lines
    function Ln($n = 1) {
        $this->y += $n * $this->size_font;
    }

    // Draw a cell
    function Cell($w, $h, $txt, $border = 0, $align = 'L', $fill = false) {
        $this->WriteMultiCell($w, $h, $txt, $border, $align, $fill);
    }
}

