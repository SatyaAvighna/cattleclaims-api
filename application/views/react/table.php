<Row>
<div style={{"marginRight":"5px"}}>
  {/* searchbar,pagination,filter */}
  <input
    type="text"
    style={{ float: "left", marginBottom: "10px" }}
    onChange={this.handleFilter}
    placeholder="Search..."
  />
  <DataTable
    data={paginatedData}
    columns={this.state.tableClms}
    pagination
    paginationServer
    paginationTotalRows={
      this.state.filteredData
        ? this.state.filteredData.length
        : this.state.data.length
    }
    onChangeRowsPerPage={this.handlePerRowsChange}
    onChangePage={this.handlePageChange}
    paginationPerPage={this.state.itemsPerPage}
    keyField="id"
    className="table table-striped table-bordered dataTable no-footer employeesTableIcons"
  />
</div>
  </Row>
