# Admin Product Creation Instructions

## How to Add Products for the Frontend

### 1. Product Line Selection
- **Required**: Select the appropriate Product Line (Door Style + Door Color combination)
- This determines which categories and subcategories will be available

### 2. Category Selection
- **Single Selection Only**: Choose exactly ONE category
- Only categories linked to the selected Product Line will be shown
- The system automatically selects all subcategories for the chosen category

### 3. Product Information

#### **Product Name**
- This will be displayed as the product name on the frontend
- Example: "B12 Base", "W1230 Wall", "2 Drawer Base Cabinet"

#### **Price**
- This becomes the "Unit Price" on the frontend
- Enter the base price of the product

#### **Labor Cost**
- **Default**: $30.00
- This is the labor cost that gets added when assembly is selected
- Shows as "Labor" column on the frontend

#### **Hinge Type**
- **Format Options**:
  - `L` = Left hinge only
  - `R` = Right hinge only  
  - `L, R` or `L/R` = Both left and right hinges available
  - `Both` = Both left and right hinges (displays as L R buttons)
  - `N/A` = No hinges (for drawer products)
- **Frontend Display**: Shows as "L", "R", "L/R", "L R", or "N/A"

#### **Is Modifiable**
- **Checked** = `modifications: true` (shows edit icon)
- **Unchecked** = `modifications: false` (shows "N/A")
- Controls whether the modification button appears on the frontend

### 4. SKU Generation
- **Auto-generated**: Based on Product Line + Product Name + Timestamp
- **Format**: `DOORSTYLE-DOORCOLOR-PRODUCTNAME-TIMESTAMP`
- **Editable**: Can be manually changed if needed

### 5. Frontend Integration

#### **Product Display**
- Products appear in the grid when users select a category/subcategory
- Each product shows:
  - Product name and image
  - Stock status (currently "In Stock")
  - Unit price
  - Hinge options
  - Modification availability

#### **Cart Functionality**
- **Quantity**: Users can set quantity (0 or more)
- **Assembly Toggle**: When enabled, adds Labor Cost to each item
- **Subtotal**: (Quantity × Unit Price) + (Quantity × Labor Cost) if assembly selected
- **Grand Total**: Sum of all items in cart

#### **Assembly Cost**
- **Fixed**: $30 per item (can be customized in the future)
- **Labor Cost**: From the product's Labor Cost field
- **Total Assembly Cost**: Assembly Cost + Labor Cost per item

### 6. Example Product Setup

**For a Base Cabinet:**
- **Product Name**: "B12 Base Cabinet"
- **Price**: $150.00
- **Labor Cost**: $25.00
- **Hinge Type**: "L, R"
- **Is Modifiable**: ✓ (checked)

**Frontend Result:**
- Shows as "B12 Base Cabinet" in product grid
- Unit Price: $150.00
- Hinge: Shows "L/R" option
- Modifications: Shows edit icon
- Assembly: Adds $30 + $25 = $55 per item when selected

### 7. Stock Management
- Currently shows "In Stock" for all products
- Future enhancement: Add stock quantity field

### 8. Image Management
- Product images are currently placeholder
- Future enhancement: Add product image upload

### 9. Testing
1. Create products with different hinge types
2. Test assembly toggle functionality
3. Verify cart calculations
4. Check modification button display
5. Test category/subcategory filtering

### 10. Troubleshooting
- **No products showing**: Check if products are linked to the correct categories/subcategories
- **Wrong categories**: Verify Product Line has the correct category relationships
- **Cart not working**: Check browser console for JavaScript errors
- **Prices not updating**: Verify Labor Cost field is filled 