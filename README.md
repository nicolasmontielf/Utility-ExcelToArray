# ExcelToArray
### Description
Converts an Excel file to a PHP array.

### Things to keep in mind.
The Excel file should not contain spaces at the beginning of the row or column. In the first row, the field names should be listed. This name will be the key for each element in the array, so as a convention, keep everything in lowercase and separated by underscores. Example: Product price -> product_price

### Steps to use
1. Install composer with `composer install`.
2. To avoid permission problems, create two empty folders in the root of the product:
    - excel: Where the Excel files to be converted will be stored.
    - result: Where the generated txt files will be saved.
3. Open a shell and run php index.php.
