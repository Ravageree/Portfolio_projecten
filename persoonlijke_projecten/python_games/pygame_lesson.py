import pygame, sys
pygame.init()

# size of your screen
screen = pygame.display.set_mode((400,400))
pygame.display.set_caption("Test Window") #this is to name your screen
clock = pygame.time.Clock() # this is to set your FPS

while True:
    for event in pygame.event.get():
        if event.type == pygame.QUIT:
            pygame.quit()
            sys.exit()
            
    screen.fill((0,0,0)) # R, G, B | 0 - 255
    pygame.draw.rect(screen, (255,0,0), (185, 185, 50, 50)) # x, y, size
    
    # to update your screen
    pygame.display.flip() 
    clock.tick(60) # this is to set your FPS to 60
