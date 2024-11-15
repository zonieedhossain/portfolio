// Initial load
document.addEventListener('DOMContentLoaded', () => {
    fetchContent('/api/summary');
});

// Menu item click handlers
document.querySelectorAll('.nav-item').forEach(button => {
    button.addEventListener('click', () => {
        // Update active state
        document.querySelectorAll('.nav-item').forEach(btn =>
            btn.classList.remove('active'));
        button.classList.add('active');

        // Update path and fetch content
        const path = button.dataset.path;
        document.getElementById('current-path').textContent = path;
        fetchContent(path);
    });
});

// Send button click handler
document.querySelector('.send-btn').addEventListener('click', () => {
    const path = document.getElementById('current-path').textContent;
    fetchContent(path);
});

// Window controls
document.querySelector('.window-button.close').onclick = () => {
    document.querySelector('.terminal').style.display = 'none';
};

document.querySelector('.window-button.minimize').onclick = () => {
    const content = document.querySelector('.terminal-content');
    content.style.display = content.style.display === 'none' ? 'block' : 'none';
};

document.querySelector('.window-button.maximize').onclick = () => {
    const terminal = document.querySelector('.terminal');
    if (terminal.style.height === '100vh') {
        terminal.style.height = 'calc(100vh - var(--nav-height) - 4rem)';
        terminal.style.position = 'relative';
    } else {
        terminal.style.height = '100vh';
        terminal.style.position = 'fixed';
        terminal.style.top = '0';
        terminal.style.left = '0';
        terminal.style.right = '0';
        terminal.style.zIndex = '1001';
    }
};

// Fetch content function
async function fetchContent(path) {
    const startTime = performance.now();
    const statusDot = document.querySelector('.status-dot');

    try {
        statusDot.style.background = '#ffbd2e'; // Loading state
        const response = await fetch(path);
        const data = await response.json();

        const endTime = performance.now();
        const responseTime = (endTime - startTime).toFixed(2);

        // Update content
        document.getElementById('content').innerHTML = formatContent(data.data, path);
        document.getElementById('status-text').textContent = `Status: ${data.status}`;
        document.getElementById('response-time').textContent = `Time: ${responseTime} ms`;
        statusDot.style.background = '#27c93f'; // Success state

    } catch (error) {
        console.error('Error:', error);
        document.getElementById('content').innerHTML =
            '<p class="error">Error loading content</p>';
        statusDot.style.background = '#ff5f56'; // Error state
        document.getElementById('status-text').textContent = 'Status: 500';
    }
}

// Format content based on section
function formatContent(data, path) {
    switch(path) {
        case '/api/summary':
            return `
                <div class="summary-section">
                    <p class="summary">${data}</p>
                </div>
            `;

        case '/api/experience':
            return data.map(exp => `
                <div class="experience-item">
                    <h3>${exp.title}</h3>
                    <h4>${exp.company}</h4>
                    <p class="period">${exp.period}</p>
                    <p class="description">${exp.description}</p>
                    ${exp.achievements ? `
                        <ul class="achievements">
                            ${exp.achievements.map(achievement =>
                `<li>${achievement}</li>`).join('')}
                        </ul>
                    ` : ''}
                    ${exp.skills ? `
                        <div class="tech-stack">
                            ${exp.skills.map(skill =>
                `<span class="tech-tag">${skill}</span>`).join('')}
                        </div>
                    ` : ''}
                </div>
            `).join('');

        case '/api/projects':
            return data.map(project => `
                <div class="project-item">
                    <div class="project-header">
                        <h3>${project.title}</h3>
                        <div class="project-links">
                            ${project.url ? `
                                <a href="${project.url}" target="_blank" class="project-link">
                                    <i class="fas fa-external-link-alt"></i> Live Demo
                                </a>
                            ` : ''}
                            ${project.github ? `
                                <a href="${project.github}" target="_blank" class="project-link">
                                    <i class="fab fa-github"></i> GitHub
                                </a>
                            ` : ''}
                        </div>
                    </div>
                    <p class="description">${project.description}</p>
                    <div class="tech-stack">
                        ${project.technologies.map(tech =>
                `<span class="tech-tag">${tech}</span>`).join('')}
                    </div>
                </div>
            `).join('');

        case '/api/skills':
            return `
                <div class="skills-container">
                    ${data.map(category => `
                        <div class="skill-category">
                            <h3>${category.category}</h3>
                            <div class="tech-stack">
                                ${category.items.map(skill =>
                `<span class="tech-tag">${skill}</span>`).join('')}
                            </div>
                        </div>
                    `).join('')}
                </div>
            `;

        case '/api/education':
            return `
                <div class="education-section">
                    <div class="education-item">
                        <h3>${data.education.degree}</h3>
                        <h4>${data.education.institution}</h4>
                        <p class="period">${data.education.period}</p>
                        ${data.education.gpa ? `<p class="gpa">GPA: ${data.education.gpa}</p>` : ''}
                    </div>
                    ${data.certifications ? `
                        <div class="certifications">
                            <h3>Certifications</h3>
                            <ul>
                                ${data.certifications.map(cert =>
                `<li>${cert}</li>`).join('')}
                            </ul>
                        </div>
                    ` : ''}
                </div>
            `;

        case '/api/publications':
            return data.map(pub => `
                <div class="publication-item">
                    <h3>${pub.title}</h3>
                    <p class="authors">${pub.authors.join(', ')}</p>
                    <p class="publisher">${pub.publisher} (${pub.date})</p>
                    ${pub.url ? `
                        <a href="${pub.url}" target="_blank" class="publication-link">
                            <i class="fas fa-external-link-alt"></i> View Publication
                        </a>
                    ` : ''}
                </div>
            `).join('');

        default:
            return '<p class="error">Section not found</p>';
    }
}

// Terminal drag functionality
let isDragging = false;
let currentX;
let currentY;
let initialX;
let initialY;
let xOffset = 0;
let yOffset = 0;

const terminal = document.querySelector('.terminal');
const terminalHeader = document.querySelector('.terminal-header');

terminalHeader.addEventListener('mousedown', dragStart);
document.addEventListener('mousemove', drag);
document.addEventListener('mouseup', dragEnd);

function dragStart(e) {
    if (e.target.classList.contains('window-button')) return;

    initialX = e.clientX - xOffset;
    initialY = e.clientY - yOffset;

    if (e.target === terminalHeader) {
        isDragging = true;
    }
}

function drag(e) {
    if (isDragging) {
        e.preventDefault();
        currentX = e.clientX - initialX;
        currentY = e.clientY - initialY;
        xOffset = currentX;
        yOffset = currentY;
        setTranslate(currentX, currentY, terminal);
    }
}

function dragEnd() {
    initialX = currentX;
    initialY = currentY;
    isDragging = false;
}

function setTranslate(xPos, yPos, el) {
    el.style.transform = `translate3d(${xPos}px, ${yPos}px, 0)`;
}

function updatePageTitle(sectionTitle) {
    document.title = `MD. ZONIEED HOSSAIN | ${sectionTitle} Portfolio`;

    document.querySelector('.terminal-title').textContent = `~/portfolio/${sectionTitle.toLowerCase()}`;
}

document.querySelectorAll('.nav-item').forEach(button => {
    button.addEventListener('click', () => {
        // Remove active class from all buttons
        document.querySelectorAll('.nav-item').forEach(btn => {
            btn.classList.remove('active');
        });

        // Add active class to clicked button
        button.classList.add('active');

        // Update path and fetch content
        const path = button.dataset.path;
        const sectionTitle = button.dataset.title;
        document.getElementById('current-path').textContent = path;
        updatePageTitle(sectionTitle);  // Add this line
        fetchContent(path);
    });
});

// Update initial page title
document.addEventListener('DOMContentLoaded', () => {
    updatePageTitle('Summary');
    fetchContent('/api/summary');
});

function showLoading() {
    document.getElementById('content').innerHTML = `
        <div class="loading">
            <p class="loading-text">Waiting for response...</p>
        </div>
    `;
    document.querySelector('.status-dot').style.background = '#ffbd2e';
}

function showResponse(content) {
    document.getElementById('content').innerHTML = content;
    document.querySelector('.status-dot').style.background = '#27c93f';
}


async function fetchContent(path) {
    try {
        const data = {
            status: 200,
            time: 0,
            data: null
        };

        // Update the UI for the waiting state
        document.getElementById('status-text').textContent = `Status: ${data.status}`;
        document.getElementById('response-time').textContent = `Time: 0.00 ms`;
        showLoading();

        return data;
    } catch (error) {
        console.error('Error:', error);
        document.getElementById('content').innerHTML = '<p class="error">Error loading content</p>';
        document.querySelector('.status-dot').style.background = '#ff5f56';
    }
}

// Send button click handler
document.querySelector('.send-btn').addEventListener('click', async () => {
    const startTime = performance.now();
    const path = document.getElementById('current-path').textContent;

    try {
        const response = await fetch(path);
        const data = await response.json();

        const endTime = performance.now();
        const responseTime = (endTime - startTime).toFixed(2);

        // Update content
        showResponse(formatContent(data.data, path));
        document.getElementById('status-text').textContent = `Status: ${data.status}`;
        document.getElementById('response-time').textContent = `Time: ${responseTime} ms`;
    } catch (error) {
        console.error('Error:', error);
        document.getElementById('content').innerHTML = '<p class="error">Error loading content</p>';
        document.querySelector('.status-dot').style.background = '#ff5f56';
    }
});

// Initial load and menu click handlers remain the same but use showLoading
document.addEventListener('DOMContentLoaded', () => {
    updateTitles('Summary');
    showLoading();
});

document.querySelectorAll('.nav-item').forEach(button => {
    button.addEventListener('click', () => {
        // Remove active class from all buttons
        document.querySelectorAll('.nav-item').forEach(btn => {
            btn.classList.remove('active');
        });

        // Add active class to clicked button
        button.classList.add('active');

        // Update path and show loading
        const path = button.dataset.path;
        const sectionTitle = button.dataset.title;
        document.getElementById('current-path').textContent = path;
        updateTitles(sectionTitle);
        showLoading();
    });
});

function updateContent(path, data) {
    switch (path) {
        case '/api/summary':
            document.querySelector('.summary').textContent = data;
            break;
        case '/api/experience':
            document.getElementById('content').innerHTML = formatExperience(data);
            break;
        case '/api/projects':
            document.getElementById('content').innerHTML = formatProjects(data);
            break;
        case '/api/skills':
            document.getElementById('content').innerHTML = formatSkills(data);
            break;
        case '/api/education':
            document.getElementById('content').innerHTML = formatEducation(data);
            break;
        case '/api/publications':
            document.getElementById('content').innerHTML = formatPublications(data);
            break;
        default:
            document.getElementById('content').innerHTML = '<p class="error">Section not found</p>';
            break;
    }
}

function formatExperience(data) {
    return data.map(exp => `
        <div class="experience-item">
            <h3>${exp.title}</h3>
            <h4>${exp.company}</h4>
            <p class="period">${exp.period}</p>
            <p class="description">${exp.description}</p>
            ${exp.achievements ? `
                <ul class="achievements">
                    ${exp.achievements.map(achievement =>
        `<li>${achievement}</li>`
    ).join('')}
                </ul>
            ` : ''}
            ${exp.skills ? `
                <div class="tech-stack">
                    ${exp.skills.map(skill =>
        `<span class="tech-tag">${skill}</span>`
    ).join('')}
                </div>
            ` : ''}
        </div>
    `).join('');
}

function formatProjects(data) {
    return data.map(project => `
        <div class="project-item">
            <div class="project-header">
                <h3>${project.title}</h3>
                <div class="project-links">
                    ${project.url ? `
                        <a href="${project.url}" target="_blank" class="project-link">
                            <i class="fas fa-external-link-alt"></i> Live Demo
                        </a>
                    ` : ''}
                    ${project.github ? `
                        <a href="${project.github}" target="_blank" class="project-link">
                            <i class="fab fa-github"></i> GitHub
                        </a>
                    ` : ''}
                </div>
            </div>
            <p class="description">${project.description}</p>
            <div class="tech-stack">
                ${project.technologies.map(tech =>
        `<span class="tech-tag">${tech}</span>`
    ).join('')}
            </div>
        </div>
    `).join('');
}

function formatSkills(data) {
    return `
        <div class="skills-container">
            ${data.map(category => `
                <div class="skill-category">
                    <h3>${category.category}</h3>
                    <div class="tech-stack">
                        ${category.items.map(skill =>
        `<span class="tech-tag">${skill}</span>`
    ).join('')}
                    </div>
                </div>
            `).join('')}
        </div>
    `;
}

function formatEducation(data) {
    return `
        <div class="education-section">
            <div class="education-item">
                <h3>${data.education.degree}</h3>
                <h4>${data.education.institution}</h4>
                <p class="period">${data.education.period}</p>
                ${data.education.gpa ? `<p class="gpa">GPA: ${data.education.gpa}</p>` : ''}
            </div>
            ${data.certifications ? `
                <div class="certifications">
                    <h3>Certifications</h3>
                    <ul>
                        ${data.certifications.map(cert =>
        `<li>${cert}</li>`
    ).join('')}
                    </ul>
                </div>
            ` : ''}
        </div>
    `;
}

function formatPublications(data) {
    return data.map(pub => `
        <div class="publication-item">
            <h3>${pub.title}</h3>
            <p class="authors">${pub.authors.join(', ')}</p>
            <p class="publisher">${pub.publisher} (${pub.date})</p>
            ${pub.url ? `
                <a href="${pub.url}" target="_blank" class="publication-link">
                    <i class="fas fa-external-link-alt"></i> View Publication
                </a>
            ` : ''}
        </div>
    `).join('');
}

