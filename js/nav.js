const $dropdown = $j(".dropdown");
const $dropdownToggle = $j(".dropdown-toggle");
const $dropdownMenu = $j(".dropdown-menu");
const showClass = "show";

$j(window).on("load resize", function() {
  if (this.matchMedia("(min-width: 768px)").matches) {
    $dropdown.hover(
      function() {
        const $this = $j(this);
        $this.addClass(showClass);
        $this.find($dropdownToggle).attr("aria-expanded", "true");
        $this.find($dropdownMenu).addClass(showClass);
      },
      function() {
        const $this = $j(this);
        $this.removeClass(showClass);
        $this.find($dropdownToggle).attr("aria-expanded", "false");
        $this.find($dropdownMenu).removeClass(showClass);
      }
    );
  } else {
    $dropdown.off("mouseenter mouseleave");
  }
});

function logout() {
  $j.ajax({
      type: "POST",
      url: "/ajax/logout.php",
      dataType: 'text',
      success: function(result) {
        var base_url = window.location.origin;
        window.location.replace(base_url + "/login.php");
      },
      error: function(result) {
          alert('Unable to logout at this time');
      }
  });
}