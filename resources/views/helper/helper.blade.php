<script>
    const limitLength = (input, length) => {
        if (input.length == length) {
            return false;
        }
    }

    const preventMinus = (inputElement) => {
        if (event.key === '-') {
            event.preventDefault(); // Mencegah karakter minus ("-") ditekan

            let value = inputElement.value;

        }
    }
</script>
