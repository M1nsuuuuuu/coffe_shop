document.addEventListener("DOMContentLoaded", () => {
  // Handle favorite heart clicks to remove items from favorites
  const favoriteHearts = document.querySelectorAll(".favorite-badge")

  favoriteHearts.forEach((heart) => {
    heart.addEventListener("click", function (e) {
      e.preventDefault()
      e.stopPropagation() // Prevent triggering the parent link

      const favoriteItem = this.closest(".favorite-item")
      const drinkId = this.getAttribute("data-drink-id")

      // Send AJAX request to remove from favorites
      fetch(`/favorites/remove/${drinkId}`, {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
        },
        credentials: "same-origin",
      })
        .then((response) => {
          if (response.ok) {
            // Animate removal of the favorite item
            favoriteItem.style.opacity = "0"
            setTimeout(() => {
              favoriteItem.style.height = "0"
              favoriteItem.style.margin = "0"
              favoriteItem.style.padding = "0"
              favoriteItem.style.overflow = "hidden"

              setTimeout(() => {
                favoriteItem.remove()

                // If no favorites left, show empty message
                const favoritesList = document.querySelector(".favorites-list")
                if (favoritesList && favoritesList.children.length === 0) {
                  const emptyMessage = document.createElement("p")
                  emptyMessage.className = "empty-message"
                  emptyMessage.textContent = "У вас пока нет сохраненных напитков"
                  favoritesList.appendChild(emptyMessage)
                }
              }, 300)
            }, 300)
          } else {
            console.error("Failed to remove from favorites")
          }
        })
        .catch((error) => {
          console.error("Error:", error)
        })
    })
  })
})
