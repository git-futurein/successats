<footer class="footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <span id="currentYear"></span> © Success HR.
            </div>
            <div class="col-sm-6">
                <div class="text-sm-end d-none d-sm-block">
                    Developed by <a href="https://digipixel.sg/" target="_blank" class="text-reset">Digipixel</a>
                </div>
            </div>
        </div>
    </div>
</footer>

<script>
    let currentYear = new Date().getFullYear();
    let yearSpan = document.getElementById("currentYear");
    yearSpan.textContent = currentYear;
</script>
