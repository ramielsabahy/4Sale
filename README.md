## Restaurant Reservation APIs

### Assumptions
- order -> reservation is one to one
- Reservations -> Added date column as reservations might be in the future
- Added Waiters table as it is needed in the flow
- Check available time API : 
  - Added both SQL and Eloquent ORM codes
  - Retrieving available table based on number of seats , date and time
  - Retrieving list of tables along with their IDs to let the customer select his table
- Reserve Table API :
  - Reserving the table based on customer selection in the previous step
  - Checking again if the table is still available as it might be taken by another customer while the current customer is still choosing his table
- List All Items API :
  - Listing all meals that are still have available quantity as no need to show a zero quantity item to the user
- Place Order API :
  - Again validating that each item selected are still available as they might be ran out during selecting the meals
  - Making a DB transaction to be able to insert in both order and order_details table with no errors while inserting in one of them
  - Saving the order
  - Saving the order_details but making the discount on each meal depending on the discount value of it
  - Updating Order table to have the total value of all order_items
  - Committing the transaction otherwise it will be rolled back
- Getting Invoice and Checkout
  - Getting the invoice by customer_id and table_id
  - Getting user Order record which is not paid yet
  - Update the order to be paid and return all of the order components to the API
  - 
