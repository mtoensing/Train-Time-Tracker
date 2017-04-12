# Train Time Tracker

## Synopsis

3T (Train Time Tracker) displays the departure time of your favorite trains at a glance.  

## Code Example

### 1. Step

Make the folder /output writable (chmod 777)

### 2. Step 

example generate.php:

```require_once('TrainTimeTracker.php');```
   
```generateJSON('Hamburg-Langenfelde','Sternschanze');```

Execute generate.php with a cronjob at least every minute. 

### 3. Step

index.php should list all generated json files.


