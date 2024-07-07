import { Controller } from "@hotwired/stimulus";

export default class extends Controller {
  static targets = ["tableBody", "pagination", "perPageSelect"];

  connect() {
    this.rowsPerPage = parseInt(this.perPageSelectTarget.value);
    this.rows = Array.from(this.tableBodyTarget.querySelectorAll("tr"));
    this.createPagination();
  }

  displayPage(page) {
    const startIndex = (page - 1) * this.rowsPerPage; //what is the first element on the current displayed page
    const endIndex = startIndex + this.rowsPerPage;
    this.rows.forEach((row, index) => {
      row.style.display = index >= startIndex && index < endIndex ? "" : "none";
    });
  }

  createPagination() {
    this.paginationTarget.innerHTML = "";

    const numPages = Math.ceil(this.rows.length / this.rowsPerPage);
    for (let i = 1; i <= numPages; i++) {
      const li = document.createElement("li");
      li.className = "page-item";
      const a = document.createElement("a");
      a.className = "page-link";
      a.textContent = i;
      a.href = "#";
      a.addEventListener("click", (e) => {
        e.preventDefault();
        this.displayPage(i);
        this.paginationTarget.querySelectorAll(".page-item").forEach((li) => li.classList.remove("active"));
        li.classList.add("active");
      });
      li.appendChild(a);
      this.paginationTarget.appendChild(li);
    }

    if (numPages > 0) {
      this.paginationTarget.querySelector(".page-item").classList.add("active");
      this.displayPage(1);
    }
  }

  changeRowsPerPage() {
    this.rowsPerPage = parseInt(this.perPageSelectTarget.value);
    this.createPagination();
  }
}
