import pygame, sys
pygame.init()
pygame.mixer.init()

# Set up the screen
screen = pygame.display.set_mode((400, 400))
clock = pygame.time.Clock()

# Load the sounds
def load_sounds():
    sound_1 = pygame.mixer.Sound('C:/Users/Ravag/Desktop/bit-academy/persoonlijke_projecten/python_games/python_soundboard/sounds/and_ill_do_it_again.mp3')
    sound_2 = pygame.mixer.Sound('C:/Users/Ravag/Desktop/bit-academy/persoonlijke_projecten/python_games/python_soundboard/sounds/huh!.mp3')
    sound_3 = pygame.mixer.Sound('C:/Users/Ravag/Desktop/bit-academy/persoonlijke_projecten/python_games/python_soundboard/sounds/i_already_told_ya_that.mp3')
    sound_4 = pygame.mixer.Sound('C:/Users/Ravag/Desktop/bit-academy/persoonlijke_projecten/python_games/python_soundboard/sounds/scoreboard!.mp3')
    sound_5 = pygame.mixer.Sound('C:/Users/Ravag/Desktop/bit-academy/persoonlijke_projecten/python_games/python_soundboard/sounds/shhiiiiii.mp3')
    sound_6 = pygame.mixer.Sound('C:/Users/Ravag/Desktop/bit-academy/persoonlijke_projecten/python_games/python_soundboard/sounds/shrimp_alfredo.mp3')
    sound_7 = pygame.mixer.Sound('C:/Users/Ravag/Desktop/bit-academy/persoonlijke_projecten/python_games/python_soundboard/sounds/womp_womp.mp3')
    sound_8 = pygame.mixer.Sound('C:/Users/Ravag/Desktop/bit-academy/persoonlijke_projecten/python_games/python_soundboard/sounds/yippee.mp3')
    sound_9 = pygame.mixer.Sound('C:/Users/Ravag/Desktop/bit-academy/persoonlijke_projecten/python_games/python_soundboard/sounds/why_are_you_gay.mp3')
    return sound_1, sound_2, sound_3, sound_4, sound_5, sound_6, sound_7, sound_8, sound_9

class SoundboardButton:
    def __init__(self, x, y, color, sound):
        self.rect = pygame.Rect(x, y, 70, 70)
        self.default_color = color
        self.current_color = color
        self.darker_color = tuple(max(0, c - 100) for c in color)  # Darker shade of the color
        self.sound = sound
        self.playing = False

    def draw(self, screen):
        pygame.draw.rect(screen, self.current_color, self.rect)

    def toggle_color(self):
        if self.current_color == self.default_color:
            self.current_color = self.darker_color
        else:
            self.current_color = self.default_color
            
    def play_sound(self):
        if not self.playing:
            self.sound.play()
            self.playing = True
            self.current_color = self.darker_color

    def stop_sound(self):
        if self.sound.get_num_channels() == 0:
            self.playing = False
            self.current_color = self.default_color

# Load sounds
sounds = load_sounds()

# Create a 3x3 grid of buttons
buttons = []
colors = [(255, 0, 0), (0, 0, 255), (0, 255, 0)]  # Red, Blue, Green
for row in range(3):
    for col in range(3):
        x = 85 + col * 80
        y = 85 + row * 80
        sound = sounds[row * 3 + col]
        buttons.append(SoundboardButton(x, y, colors[row], sound))

# Game loop
while True:
    for event in pygame.event.get():
        if event.type == pygame.QUIT:
            pygame.quit()
            sys.exit()
        if event.type == pygame.KEYDOWN:
            if event.key == pygame.K_1:
                buttons[0].play_sound()
            if event.key == pygame.K_2:
                buttons[1].play_sound()
            if event.key == pygame.K_3:
                buttons[2].play_sound()
            if event.key == pygame.K_4:
                buttons[3].play_sound()
            if event.key == pygame.K_5:
                buttons[4].play_sound()
            if event.key == pygame.K_6:
                buttons[5].play_sound()
            if event.key == pygame.K_7:
                buttons[6].play_sound()
            if event.key == pygame.K_8:
                buttons[7].play_sound()
            if event.key == pygame.K_9:
                buttons[8].play_sound()

    # Check if sounds have finished and reset colors if needed
    for button in buttons:
        button.stop_sound()

    # Fill the screen with a background color
    screen.fill((115, 60, 170))  # Purple background

    # Draw all buttons
    for button in buttons:
        button.draw(screen)

    # Update the display
    pygame.display.flip()
    clock.tick(60)  # Limit the frame rate to 60 FPS
