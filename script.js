// Global variables
let startIndex = 0;
const maxResults = 20;
let currentQuery = '';
let isLoading = false;
let favoritesMode = false;

// Add your Google Books API key here (recommended for proper API access)
// Get an API key from: https://developers.google.com/books/docs/v1/using#APIKey
const API_KEY = ''; // You'll need to add your own API key here

// DOM elements
const searchInput = document.getElementById('searchInput');
const searchButton = document.getElementById('searchButton');
const sortFilter = document.getElementById('sortFilter');
const booksGrid = document.getElementById('booksGrid');
const loadMoreBtn = document.getElementById('loadMore');
const modal = document.getElementById('bookModal');
const modalContent = document.getElementById('modalContent');
const closeModal = document.getElementsByClassName('close')[0];
const userNameDisplay = document.getElementById('userNameDisplay');
const logoutBtn = document.getElementById('logoutBtn');
const favoritesToggle = document.getElementById('favoritesToggle');

// Check authentication status
function checkAuthentication() {
    const currentUser = localStorage.getItem('bookExplorerUser');
    if (!currentUser) {
        window.location.href = 'login.html';
        return false;
    }
    return JSON.parse(currentUser);
}

// Update user display
function updateUserDisplay() {
    const user = checkAuthentication();
    if (user && userNameDisplay) {
        userNameDisplay.textContent = `Welcome, ${user.fullName}`;
    }
}

// Handle logout
function setupLogout() {
    if (logoutBtn) {
        logoutBtn.addEventListener('click', function() {
            localStorage.removeItem('bookExplorerUser');
            window.location.href = 'login.html';
        });
    }
}

// Favorites Management
function getFavorites() {
    const user = checkAuthentication();
    if (!user) return [];
    
    const favorites = localStorage.getItem(`bookExplorerFavorites_${user.email}`);
    return favorites ? JSON.parse(favorites) : [];
}

function saveFavorites(favorites) {
    const user = checkAuthentication();
    if (!user) return;
    
    localStorage.setItem(`bookExplorerFavorites_${user.email}`, JSON.stringify(favorites));
}

function toggleFavorite(bookId, bookData) {
    const favorites = getFavorites();
    const existingIndex = favorites.findIndex(book => book.id === bookId);
    
    if (existingIndex >= 0) {
        // Remove from favorites
        favorites.splice(existingIndex, 1);
        saveFavorites(favorites);
        return false;
    } else {
        // Add to favorites
        favorites.push(bookData);
        saveFavorites(favorites);
        return true;
    }
}

function isFavorite(bookId) {
    const favorites = getFavorites();
    return favorites.some(book => book.id === bookId);
}

// API functions
async function fetchBooks(query, start = 0) {
    if (!query) return null;
    
    const orderBy = sortFilter.value;
    let url = `https://www.googleapis.com/books/v1/volumes?q=${encodeURIComponent(query)}&startIndex=${start}&maxResults=${maxResults}&orderBy=${orderBy}`;
    
    // Add API key if provided
    if (API_KEY) {
        url += `&key=${API_KEY}`;
    }
    
    try {
        console.log('Fetching books from URL:', url);
        const response = await fetch(url);
        
        if (!response.ok) {
            console.error('API response not ok:', response.status, response.statusText);
            throw new Error(`Network response was not ok: ${response.status} ${response.statusText}`);
        }
        
        const data = await response.json();
        console.log('API response data:', data);
        return data;
    } catch (error) {
        console.error('Error fetching books:', error);
        throw error;
    }
}

// Create book card HTML
function createBookCard(book) {
    if (!book || !book.volumeInfo) {
        console.error('Invalid book data:', book);
        return '';
    }
    
    const volumeInfo = book.volumeInfo;
    const thumbnail = volumeInfo.imageLinks?.thumbnail || '/api/placeholder/200/300';
    const authors = volumeInfo.authors ? volumeInfo.authors.join(', ') : 'Unknown Author';
    const averageRating = volumeInfo.averageRating || '-';
    const title = volumeInfo.title || 'Unknown Title';
    const isFav = isFavorite(book.id);

    return `
        <div class="book-card" data-id="${book.id}">
            <div class="favorite-toggle ${isFav ? 'favorited' : ''}" data-id="${book.id}">
                <span class="heart-icon">♥</span>
            </div>
            <img src="${thumbnail}" alt="${title}" class="book-image"
                onerror="this.src='/api/placeholder/200/300'">
            <div class="book-info">
                <h3 class="book-title">${title}</h3>
                <p class="book-author">by ${authors}</p>
                ${averageRating !== '-' ? `
                    <p class="book-rating">
                        <span class="star">★</span> ${averageRating}
                    </p>
                ` : ''}
            </div>
        </div>
    `;
}

// Display books in the grid
function displayBooks(books, append = false) {
    // Remove any existing loading message
    const loadingDiv = document.querySelector('.loading');
    if (loadingDiv) loadingDiv.remove();
    
    if (!append) {
        booksGrid.innerHTML = '';
    }

    if (!books || books.length === 0) {
        booksGrid.innerHTML = '<div class="no-results">No books found</div>';
        loadMoreBtn.style.display = 'none';
        return;
    }

    const booksHTML = books.map(book => createBookCard(book)).join('');
    
    if (append) {
        booksGrid.innerHTML += booksHTML;
    } else {
        booksGrid.innerHTML = booksHTML;
    }

    // Show/hide load more button
    loadMoreBtn.style.display = (books.length < maxResults || favoritesMode) ? 'none' : 'block';
    
    // Add event listeners to favorite toggles
    document.querySelectorAll('.favorite-toggle').forEach(toggle => {
        toggle.addEventListener('click', function(e) {
            e.stopPropagation(); // Prevent opening modal
            const bookId = this.dataset.id;
            const bookCard = this.closest('.book-card');
            const bookIndex = Array.from(document.querySelectorAll('.book-card')).indexOf(bookCard);
            
            let bookData;
            if (favoritesMode) {
                bookData = getFavorites().find(book => book.id === bookId);
            } else {
                // Find book data in the current display
                const books = booksGrid.querySelectorAll('.book-card');
                if (bookIndex >= 0 && bookIndex < books.length) {
                    const bookId = books[bookIndex].dataset.id;
                    const allCurrentBooks = document.querySelectorAll('.book-card');
                    bookData = allCurrentBooks[bookIndex].__bookData;
                }
            }
            
            // If we don't have the book data yet, fetch it
            if (!bookData) {
                fetchBookDetails(bookId).then(data => {
                    const isFav = toggleFavorite(bookId, data);
                    this.classList.toggle('favorited', isFav);
                    
                    // If in favorites mode and removing a favorite, remove the card
                    if (favoritesMode && !isFav) {
                        bookCard.remove();
                        if (document.querySelectorAll('.book-card').length === 0) {
                            booksGrid.innerHTML = '<div class="no-results">No favorites yet</div>';
                        }
                    }
                });
            } else {
                const isFav = toggleFavorite(bookId, bookData);
                this.classList.toggle('favorited', isFav);
                
                // If in favorites mode and removing a favorite, remove the card
                if (favoritesMode && !isFav) {
                    bookCard.remove();
                    if (document.querySelectorAll('.book-card').length === 0) {
                        booksGrid.innerHTML = '<div class="no-results">No favorites yet</div>';
                    }
                }
            }
        });
    });
}

// Show favorite books
function showFavorites() {
    const favorites = getFavorites();
    
    if (favorites.length === 0) {
        booksGrid.innerHTML = '<div class="no-results">No favorites yet</div>';
        loadMoreBtn.style.display = 'none';
        return;
    }
    
    displayBooks(favorites);
}

// Search books
async function searchBooks(append = false) {
    if (isLoading) return;
    
    // If in favorites mode, show favorites instead
    if (favoritesMode && !append) {
        showFavorites();
        return;
    }

    let query = searchInput.value.trim();
    if (!query && !append) {
        booksGrid.innerHTML = '<div class="no-results">Please enter a search term</div>';
        loadMoreBtn.style.display = 'none';
        return;
    }

    if (!append) {
        startIndex = 0;
        currentQuery = query;
    } else {
        // If appending, make sure we're using the same query
        query = currentQuery;
    }

    isLoading = true;
    
    // Only clear previous results if this is a new search
    if (!append) {
        booksGrid.innerHTML = '';
    }
    
    booksGrid.innerHTML += '<div class="loading">Loading books...</div>';
    loadMoreBtn.disabled = true;

    try {
        console.log(`Searching for "${query}" starting at index ${startIndex}`);
        const data = await fetchBooks(query, startIndex);
        
        // Check if data exists and has items property
        if (!data || !data.items || data.items.length === 0) {
            console.log('No books found or empty response:', data);
            if (!append) {
                // Only show no results if this is a new search
                booksGrid.innerHTML = '<div class="no-results">No books found</div>';
            }
            loadMoreBtn.style.display = 'none';
            return;
        }

        // Store book data for later use
        data.items.forEach(book => {
            const existingCards = document.querySelectorAll(`.book-card[data-id="${book.id}"]`);
            existingCards.forEach(card => {
                card.__bookData = book;
            });
        });

        displayBooks(data.items, append);
        startIndex += maxResults;
        
        // Add click events to new books
        document.querySelectorAll('.book-card').forEach(card => {
            card.addEventListener('click', () => showBookDetails(card.dataset.id));
        });
    } catch (error) {
        console.error('Error in search:', error);
        booksGrid.innerHTML = '<div class="no-results">Error loading books. Please try again.</div>';
        loadMoreBtn.style.display = 'none';
    } finally {
        isLoading = false;
        loadMoreBtn.disabled = false;
        
        // Remove loading message if it still exists
        const loadingDiv = document.querySelector('.loading');
        if (loadingDiv) loadingDiv.remove();
    }
}

// Fetch book details by ID
async function fetchBookDetails(bookId) {
    try {
        let url = `https://www.googleapis.com/books/v1/volumes/${bookId}`;
        if (API_KEY) {
            url += `?key=${API_KEY}`;
        }
        
        const response = await fetch(url);
        
        if (!response.ok) {
            throw new Error('Failed to fetch book details');
        }
        
        return await response.json();
    } catch (error) {
        console.error('Error fetching book details:', error);
        throw error;
    }
}

// Show book details in modal
async function showBookDetails(bookId) {
    try {
        // Check if the book is already in favorites
        let book;
        const favorites = getFavorites();
        const favoriteBook = favorites.find(b => b.id === bookId);
        
        if (favoriteBook) {
            book = favoriteBook;
        } else {
            book = await fetchBookDetails(bookId);
        }
        
        const volumeInfo = book.volumeInfo;
        const isFav = isFavorite(bookId);

        modalContent.innerHTML = `
            <div class="modal-book-info">
                <img src="${volumeInfo.imageLinks?.thumbnail || '/api/placeholder/200/300'}"
                    alt="${volumeInfo.title || 'Book cover'}"
                    class="modal-book-image"
                    onerror="this.src='/api/placeholder/200/300'">
                <div class="modal-book-details">
                    <div class="modal-book-header">
                        <h2 class="modal-book-title">${volumeInfo.title || 'Unknown Title'}</h2>
                        <div class="modal-favorite-toggle ${isFav ? 'favorited' : ''}" data-id="${bookId}">
                            <span class="heart-icon">♥</span>
                        </div>
                    </div>
                    <p class="modal-book-author">by ${volumeInfo.authors ? volumeInfo.authors.join(', ') : 'Unknown Author'}</p>
                    ${volumeInfo.averageRating ? `
                        <p class="book-rating">
                            <span class="star">★</span> ${volumeInfo.averageRating}
                            (${volumeInfo.ratingsCount || 0} ratings)
                        </p>
                    ` : ''}
                    <p><strong>Published:</strong> ${volumeInfo.publishedDate || 'Unknown'}</p>
                    <p><strong>Publisher:</strong> ${volumeInfo.publisher || 'Unknown'}</p>
                    <p><strong>Pages:</strong> ${volumeInfo.pageCount || 'Unknown'}</p>
                    <p><strong>Categories:</strong> ${volumeInfo.categories ? volumeInfo.categories.join(', ') : 'Unknown'}</p>
                    ${volumeInfo.description ? `
                        <div class="modal-book-description">
                            <h3>Description:</h3>
                            <p>${volumeInfo.description}</p>
                        </div>
                    ` : ''}
                </div>
            </div>
        `;

        // Add event listener to favorite toggle in modal
        const modalFavToggle = modalContent.querySelector('.modal-favorite-toggle');
        if (modalFavToggle) {
            modalFavToggle.addEventListener('click', function() {
                const isFav = toggleFavorite(bookId, book);
                this.classList.toggle('favorited', isFav);
                
                // Update the book card favorites icon if visible
                const bookCardToggle = document.querySelector(`.favorite-toggle[data-id="${bookId}"]`);
                if (bookCardToggle) {
                    bookCardToggle.classList.toggle('favorited', isFav);
                }
                
                // If in favorites mode and removing a favorite, close modal and update display
                if (favoritesMode && !isFav) {
                    modal.style.display = 'none';
                    showFavorites();
                }
            });
        }

        modal.style.display = 'block';
    } catch (error) {
        console.error('Error fetching book details:', error);
        modalContent.innerHTML = '<div class="no-results">Error loading book details. Please try again.</div>';
        modal.style.display = 'block';
    }
}

// Toggle between normal and favorites mode
function toggleFavoritesMode() {
    favoritesMode = !favoritesMode;
    
    if (favoritesToggle) {
        favoritesToggle.textContent = favoritesMode ? 'Show All Books' : 'My Favorites';
        favoritesToggle.classList.toggle('active', favoritesMode);
    }
    
    if (favoritesMode) {
        showFavorites();
    } else {
        searchBooks();
    }
}

// Event listeners
function setupEventListeners() {
    if (searchButton) {
        searchButton.addEventListener('click', () => searchBooks());
    }
    
    if (searchInput) {
        searchInput.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') searchBooks();
        });
    }
    
    if (sortFilter) {
        sortFilter.addEventListener('change', () => searchBooks());
    }
    
    if (loadMoreBtn) {
        loadMoreBtn.addEventListener('click', () => searchBooks(true));
    }
    
    // Modal events
    if (closeModal) {
        closeModal.addEventListener('click', () => modal.style.display = 'none');
    }
    
    window.addEventListener('click', (e) => {
        if (e.target === modal) modal.style.display = 'none';
    });
    
    // Favorites toggle button
    if (favoritesToggle) {
        favoritesToggle.addEventListener('click', toggleFavoritesMode);
    }
}

// Initialize
document.addEventListener('DOMContentLoaded', function() {
    // Check authentication first
    const user = checkAuthentication();
    
    // Only continue if user is authenticated
    if (user) {
        updateUserDisplay();
        setupLogout();
        setupEventListeners();
        
        // Initial state
        if (loadMoreBtn) {
            loadMoreBtn.style.display = 'none';
        }
        
        // Add an initial console log to check if the script is loading properly
        console.log('Book Explorer script loaded successfully');
        
        // Check if we're able to access external APIs
        console.log('Testing API connection...');
        fetch('https://www.googleapis.com/books/v1/volumes?q=test&maxResults=1')
            .then(response => {
                console.log('API connection test response:', response.status, response.statusText);
                if (!response.ok) {
                    console.error('API connection test failed');
                    if (booksGrid) {
                        booksGrid.innerHTML = '<div class="no-results">Unable to connect to Google Books API. Please check your internet connection.</div>';
                    }
                } else {
                    console.log('API connection test successful');
                }
            })
            .catch(error => {
                console.error('API connection test error:', error);
                if (booksGrid) {
                    booksGrid.innerHTML = '<div class="no-results">Unable to connect to Google Books API. Please check your internet connection.</div>';
                }
            });
    }
});